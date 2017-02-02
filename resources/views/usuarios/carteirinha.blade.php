<!DOCTYPE html>
<html>
    <head>
        <title>Carteirinha</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <style>
            img{
                max-width: 100%;
            }

            .carteirinha {
                width: 280px;
                height: 178px;
                border: 1px solid #cccccc;
                border-radius: 10px;
                margin: 50px auto;
                padding: 10px;
                background-size: 294px auto;
                background-position: center -9px;
                background-repeat: no-repeat;
                position: relative;
            }

            .carteirinha .imgBg{
                position: absolute; 
                z-index: -1;
                width: 90%;
                top: 0;
            }

            .carteirinha table{
                width: 100%;
                padding: 0;
                margin: 0;
                border: 0;
            }

            .carteirinha h1 {
                font-size: 18px;
                font-family: arial;
                color: #8e067c;
                text-align: center;
            }

            .crt_foto, .crt_code {
                padding: 0 10%;
                text-align: center;
            }

            .crt_foto img, .crt_code img{
                border-radius: 10px;
            }

            .crt_code img{
                width: 70%;
            }

            .crt_nome {
                clear: both;
                padding: 2px 5%;
                font-size: 14px;
                font-weight: bold;
                font-family: arial;
                text-align: center;
                color: #8e067c;
                margin: 0;
                text-shadow: 2px 2px 2px #ffffff;
            }

            .btn{
                bottom: -45px;
                position: absolute;
            }
        </style>
        <div class="carteirinha">
            <img src="{{ url('/assets/img/aline.png') }}" class="imgBg"/>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2"><h1>Escolda De Dança Aline Rosa</h1></td>
                </tr>
                <tr>
                    <td width="120"><div class="crt_foto"><img src="{{ asset($usuario->foto == '' ? '/assets/img/default.png' : 'perfil/' . $usuario->foto ) }}" /></div></td>
                    <td><div class="crt_code"><img src="{{ asset('qrcode/perfil_' . $usuario->id . '.png') }}" /></div></td>
                </tr>
                <tr>
                    <td colspan="2"><p class="crt_nome">{{$usuario->nome}}</p></td>
                </tr>
            </table>
            <button class="btn btn-primary" onclick="javascript:window.print();">Imprimir</button>
        </div>
    </body>
</html>
