<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>
    </head>
    <style>
        .pie{
			background-color:#ccc;
            clear: both;
            color: #727272;
            font-family: Helvetica,Arial,sans-serif;
            font-size: 12px;
            font-variant: normal;
            font-weight: normal;
            margin: 0;
            padding: 10px 0 5px 10px;
            text-align: left;
            text-decoration: none;
            text-transform: none;

        }
        a{text-decoration: none;}
        a, a:visited, a:active{color: #0500B6;}
        a:hover{color: #FFF;}          
    </style>
    <body>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#D6AA15">
                <td width="30%" style="white-space: nowrap;font-size: 34px;font-family: verdana,arial;font-weight: normal;margin: 0;font-family: verdana,arial;font-weight: normal;">
                    <a href="">
                        <img style="width:240px" src ="https://citasenlinea.villasalud.pe/assets/img/dinamic/empresa/header-mail.jpg"> <!-- assets/images/logo-dark.png -->
                    </a>
                </td>
                <td></td>
            </tr>
            <tr>
              <td colspan="5" style="padding:15px; color:#000"; bgcolor="#990033">{contenido}</td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#fff">
                <td height="67px" class="pie">
					&copy; <?=date("Y")?> - 
				</td>
            </tr>
        </table>
    </body>
</html>