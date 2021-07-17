<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Config Editor</title>
        <link href="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/css/halfmoon-variables.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link rel="stylesheet" href="<?=ASSETS . 'style.css'?>" />
    </head>
    <body data-set-preferred-mode-onload="true">
        <div class="modal" id="modal-return" tabindex="-1" role="dialog" data-overlay-dismissal-disabled="true" data-esc-dismissal-disabled="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content w-600">
                    <a href="#" class="close" role="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    <h5 class="modal-title">Результат:</h5>
                    <div class="return_message"></div>
                    <div class="mt-20"> <!-- text-right = text-align: right, mt-20 = margin-top: 2rem (20px) -->
                        <a href="#" class="btn btn-primary btn-block" role="button">Окей</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="page-wrapper" class="page-wrapper with-transitions">
            <!-- Content wrapper start -->
            <div class="content-wrapper">
                <div class="d-flex h-full align-items-center justify-content-center flex-column">
                    <div class="card w-600 mw-full p-5 m-0 position-relative overflow-auto" style="max-height: 750px;">
                        <div id="dark_orientir" class="position-absolute top-0 right-0 z-10 p-10">
                            <button class="btn btn-square" type="button" onclick="halfmoon.toggleDarkMode()">
                                <i class="far fa-moon" aria-hidden="true"></i>
                                <span class="sr-only">Toggle dark mode</span>
                            </button>
                        </div>
                        <?php if( empty( $Core->getGet() ) ): ?>
                            <div class="text-center" id="error_core"></div>
                            <div class="m-5 mt-10">
                                <div class="card-title">Выбрать предыдущие файлы</div>
                                <div class="d-flex flex-wrap" id="last_files">
                                </div>
                            </div>
                            <div id="main_chego_blyat" class="d-flex">
                                <div class="form-group btn-block m-5">
                                    <div class="custom-file">
                                        <input type="file" id="json_validate" required="required">
                                        <label class="btn btn-block" for="json_validate">Выбрать существующий</label>
                                    </div>
                                </div>
                            </div>
                        <?php elseif( !empty( $Core->getGet() ) && $Core->getGet() == "new" ): ?>
                            <div class="position-absolute top-0 left-0 z-10 p-10">
                                <a class="btn" href="?edit=none">Назад</a>
                            </div>
                            <div class="d-flex p-5" style="margin-top: 4rem !important;">
                                Создавай
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Content wrapper end -->
        </div>
    </body>
    <footer>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/js/halfmoon.min.js"></script>
        <script type="text/javascript" src="<?=ASSETS . 'app.js'?>"></script>
    </footer>
</html>