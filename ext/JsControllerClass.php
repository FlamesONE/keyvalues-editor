<?php

namespace ext;

use Exception;

class JsControllerClass
{
    /**
     * @var array
     */
    public $allow_types = ["txt", "cfg", "ini"];

    /**
     * @var int
     */
    public $max_file_size = 10000000; // 10 MB

    /**
     * Проверяет, является ли массив ассоциативным
     * 
     * @param array $arr - Массив
     * 
     * @return bool
     */
    public function isAssoc( array $arr ) : bool
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Просто функция ради удобства
     * 
     * @param string $type - Тип, который мы тоже выводим
     * @param string|array $text - Текст, который надо будет вывести
     * 
     * @return string
     */
    public function encode( string $type, $text ) : string
    {
        return json_encode( [ "type" => $type, "text" => $text ] );
    }

    /**
     * Проверка и валидация файла
     * 
     * @return string
     */
    public function check_file( )
    {
        if( empty( $_FILES ) )
            return $this->encode("error", "Ошибка при получении файла");

        $fileName = $_FILES['file']['name'];

        $explode = explode( ".", $fileName );

        $fileAllowed = strtolower( end( $explode ) );

        $fileType = $_FILES['file']['type'];

        $fileError = $_FILES['file']['error'];

        $fileContent = file_get_contents($_FILES['file']['tmp_name']);

        $fileSize = $_FILES['file']['size'];

        if( $fileError == UPLOAD_ERR_OK )
        {
            if( $fileSize < 20 )
                return $this->encode( "error", "Файл весит слишком мало" );

            if( $fileSize >= $this->max_file_size )
                return $this->encode( "error", "Файл весит больше 10 МБ!" );

            if( !in_array( $fileAllowed, $this->allow_types ) )
                return $this->encode( "error", "Недопустимый формат файла" );

            try
            {
                return $fileContent;
            }
            catch( Exception $e )
            {
                return $this->encode("error", $e->getMessage());
            }
        }
        else
        {
            switch($fileError)
            {
                case UPLOAD_ERR_INI_SIZE:   
                    $message = 'Произошла ошибка при попытке загрузить файл, размер которого превышает допустимый.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:  
                    $message = 'Произошла ошибка при попытке загрузить файл, размер которого превышает допустимый.';
                    break;
                case UPLOAD_ERR_PARTIAL:    
                    $message = 'Ошибка: загрузка файла не завершена.';
                    break;
                case UPLOAD_ERR_NO_FILE:    
                    $message = 'Ошибка: файл не загружен.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR: 
                    $message = 'Error: servidor no configurado para carga de archivos.';
                    break;
                case UPLOAD_ERR_CANT_WRITE: 
                    $message= 'Error: posible falla al grabar el archivo.';
                    break;
                case  UPLOAD_ERR_EXTENSION: 
                    $message = 'Error: carga de archivo no completada.';
                    break;
                default: $message = 'Error: carga de archivo no completada.';
                        break;
            }
            return $this->encode( "error", $message );
        }
    }

    /**
     * Проверка, и выдача файла
     * 
     * @return string
     */
    public function send_file( )
    {
        !$_POST['data'] && die;

        $json = json_decode( $_POST["data"], true );

        if( !empty( $json ) )
            return $this->parser->kv_encode( $json );
        return null;
    }
}