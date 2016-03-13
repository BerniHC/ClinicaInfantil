<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{ Setting::get('website.name') }}</title>
		<style type="text/css">
			#outlook a{padding:0;}
			body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
			body{-webkit-text-size-adjust:none;}
			
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
			
			body, #backgroundTable{
				background-color:#FAFAFA;
			}
			
			#templateContainer{
				border:0;
			}
			
			h1, .h1{
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:40px;
				font-weight:bold;
				line-height:100%;
				margin-top:2%;
				margin-right:0;
				margin-bottom:1%;
				margin-left:0;
				text-align:left;
			}

			h2, .h2{
				color:#404040;
				display:block;
				font-family:Arial;
				font-size:18px;
				font-weight:bold;
				line-height:100%;
				margin-top:2%;
				margin-right:0;
				margin-bottom:1%;
				margin-left:0;
				text-align:left;
			}

			h3, .h3{
				color:#606060;
				display:block;
				font-family:Arial;
				font-size:16px;
				font-weight:bold;
				line-height:100%;
				margin-top:2%;
				margin-right:0;
				margin-bottom:1%;
				margin-left:0;
				text-align:left;
			}

			h4, .h4{
				color:#808080;
				display:block;
				font-family:Arial;
			    font-size:14px;
				font-weight:bold;
				line-height:100%;
				margin-top:2%;
				margin-right:0;
				margin-bottom:1%;
				margin-left:0;
				text-align:left;
			}
      
            a, a:link, a:visited {
				color:#52BCBF;
			}
			
			#templateHeader{
				background-color:#FFFFFF;
				border-bottom:5px solid #505050;
			}
			
			.headerContent{
				line-height:100%;
				padding:10px;
				text-align:left;
				vertical-align:middle;
			}
			
			.headerContent a:link, .headerContent a:visited, .headerContent a .yshortcuts {
				color:#52BCBF;
				font-weight:normal;
				text-decoration:underline;
			}
			
			#headerImage{
				height:auto;
				max-width:600px !important;
			}
			
			#templateContainer, .bodyContent{
				background-color:#FFFFFF;
			}
			
			.bodyContent div{
				color:#505050;
				font-family:Arial;
				font-size:14px;
				line-height:150%;
				text-align:justify;
			}
			
			.bodyContent div a:link, .bodyContent div a:visited, .bodyContent div a .yshortcuts {
				color:#52BCBF;
				font-weight:normal;
				text-decoration:underline;
			}
			
			.bodyContent img{
				display:inline;
				height:auto;
			}
			
			#templateFooter{
				background-color:#FFFFFF;
				border-top:3px solid #909090;
			}
			
			.footerContent div{
				color:#707070;
				font-family:Arial;
				font-size:12px;
				line-height:normal;
				text-align:center;
			}
			
			.footerContent div a:link, .footerContent div a:visited, .footerContent div a .yshortcuts {
				color:#52BCBF;
				font-weight:normal;
				text-decoration:underline;
			}
			
			.footerContent img{
				display:inline;
			}
		</style>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
            	<tr>
                	<td align="center" valign="top">
                        <br/>
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
                                        <tr>
                                        	<td class="headerContent">
                                                <h1>{{ Setting::get('website.name') }}</h1>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                        	<td valign="top" class="bodyContent">
                                            
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" style="padding-right:0;">
                                                            <div mc:edit="std_content00">
                                                                @yield('content')
															</div>
														</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter">
                                    	<tr>
                                        	<td valign="top" class="footerContent">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="footer">
                                                            <div mc:edit="std_footer">
                                                                <a href="{{ URL::to('/') }}" target="_blank">{{ Setting::get('website.name') }}</a> {{ date("Y") }}. Todos los derechos reservados.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>