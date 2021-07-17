$.getScript("assets/kvparser.js");
addcockBlocks();

$("#json_validate").on("change", (e) => {
    var formData = new FormData();
    formData.append('file', $('#json_validate')[0].files[0]);

    $.ajax({
        url : '?upload=1',
        type : 'POST',
        data : formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        success : function(data) 
        {
            try
            {
                let parse = JSON.parse( data );
                    
                return editErrorBlock( parse.text );
            }
            catch(e)
            {
                return createBlocks( KeyValue.decode( data ), $('#json_validate')[0].files[0].name );
            }
        }
    });
});

$(document).on("click", "#load_return", (e) => {
    let container = $("#main_editor > .hyase_container");

    let obj = {};

    container.each(function( index ) 
    {
        index = $( this ).find("input.creator").val();
        obj[index] = {};
        $( this ).find("input").each(function( index2 ) 
        {
            if( !$(this).hasClass("creator") )
                obj[index][$(this).attr("id")] = $( this ).val();
        });
        $( this ).find(".hyase_container").each(function( index1 ) 
        {
            index1 = $( this ).find("input.creator").val();
            obj[index][index1] = getAllContainers( $( this ) );
        });
    });

    serializeAjax( obj );
});

function addcockBlocks()
{
    let cyka = getBlocksFromCockies();
    if( typeof cyka != "undefined" )
    {
        console.log(cyka);
        for (var key in cyka) 
        {
            $("#last_files").append(`<div onclick='zalupka("${key}")' class="check_change btn btn-primary text-uppercase font-weight-semi-bold m-5 ml-0">${key}</div>`);
        }
    }
}

function zalupka( cockname )
{
    createBlocks( JSON.parse( readCookie( "file__"+cockname ) ), cockname );
}

function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

function getBlocksFromCockies()
{
    var pairs = document.cookie.split(";");
    var cookies = {};
    for (var i=0; i<pairs.length; i++)
    {
        var pair = pairs[i].split("=");
        var che = (pair[0]+'').trim().split("__");
        if( typeof che[1] != "undefined" )
            cookies[che[1]] = unescape(pair.slice(1).join('='));
    }
    return cookies;
}

function getAllContainers( container )
{
    let obj = {};

    container.each(function( index2 ) 
    {
        $( this ).find("input").each(function( index ) 
        {
            if( !$(this).hasClass("creator") )
                obj[$(this).attr("id")] = $( this ).val();
        });
        $( this ).find(".hyase_container").each(function( index1 ) 
        {
            index1 = $( this ).find("input.creator").val();
            obj[index1] = getAllContainers( $( this ) );
        });
    });

    console.log( obj );

    return obj;
}

function serializeAjax( object )
{
    $(".return_message").html( KeyValue.encode( object ) );
}

function editErrorBlock( text )
{
    $("#error_core").html( text );
}

function hideElements()
{
    $("#main_chego_blyat").addClass("d-none").removeClass("d-flex");
    $(".page-wrapper").css("overflow", "auto");
    $("#last_files").parent().remove();
    $("#dark_orientir").after(`<div class="position-absolute top-0 left-0 z-10 p-10"><a class="btn" href="?edit=none">Назад</a></div>`);
}

function createBlocks( array, name )
{
    if( typeof array != "object" )
        return editErrorBlock( "Синтаксис файла повережден." );

    if( empty( array ) )
        return editErrorBlock( "Файл нынче пустой" );

    editErrorBlock( "" );

    createCookie("file__"+name, JSON.stringify( array ), 3);

    hideElements();
    
    $("#main_chego_blyat").after('<div id="main_editor" class="d-flex" style="margin-top: 4rem !important;"></div>');

    $("#main_editor").after('<a id="load_return" href="#modal-return" class="btn btn-primary btn-block mt-20" type="button">Загрузить результат</a>');

    $.each(array, function (key, data) 
    {
        if( key == "" )
            key = "undefined"+Math.floor((Math.random() * 1000) + 1);

        if( typeof data == "string" )
        {
            $("#main_editor").append("<div class='hyase_container' id='"+key+"'><input class='form-control' type='text' value='"+data+"'></div>");
        }
        else
        {
            $("#main_editor").append("<div class='hyase_container' id='"+key+"'><input class='form-control creator' type='text' value='"+key+"'></div>");

            infCreate( key, data );
        }
    })
}

function empty( mixed_var ) 
{
	return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false  ||  ( Array.isArray(mixed_var) && mixed_var.length === 0 ) );
}

function infCreate( key, data )
{
    if( typeof data == "string" )
        $("div[id='"+key+"']").append("<div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>"+key+"</span></div><input class='form-control' type='text' value='"+data+"'></div>");
    else
    {
        $.each(data, function (index, data2) 
        {
            if( typeof data2 == "string" )
            {
                $("div[id='"+key+"']").append("<div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>"+index+"</span></div><input class='form-control' type='text' id='"+index+"' value='"+data2+"'></div>");
            }
            else
            {
                if( data2.length == 0 )
                    return;
                
                $("div[id='"+key+"']").append("<div class='hyase_container input-group' id='"+index+"'><input class='form-control creator' type='text' id='"+index+"' value='"+index+"'></div>");
                infCreate( index, data2 );
            }
        })
    }
}