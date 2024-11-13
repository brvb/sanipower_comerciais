<?php

use App\Models\User;

        $Utilizador = User::where('id', $visita['user_id'])->get();
    // dd($Utilizador);
     $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/customers/GetCustomers?id='. $visita['client_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
    
        curl_close($curl);

        $response_decoded = json_decode($response);
        $cliente = $response_decoded;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/documents/visit?visit_id='.$visita['id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
    
        curl_close($curl);

        $response_decoded = json_decode($response);
        // dd($response_decoded->documents);
        $prop_enc = $response_decoded->documents ?? null;
?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta name=Generator content="Microsoft Word 15 (filtered medium)">
    <!--[if !mso]><style>v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style><![endif]-->
    <style>
        <!--
        /* Font Definitions */
        @font-face
        	{font-family:Helvetica;
        	panose-1:2 11 6 4 2 2 2 2 2 4;}
        @font-face
        	{font-family:"Cambria Math";
        	panose-1:2 4 5 3 5 4 6 3 2 4;}
        @font-face
        	{font-family:Calibri;
        	panose-1:2 15 5 2 2 2 4 3 2 4;}
        @font-face
        	{font-family:"Aptos Display";}
        @font-face
        	{font-family:Aptos;}
        @font-face
        	{font-family:"Century Gothic";
        	panose-1:2 11 5 2 2 2 2 2 2 4;}
        /* Style Definitions */
        p.MsoNormal, li.MsoNormal, div.MsoNormal
        	{margin:0cm;
        	font-size:12.0pt;
        	font-family:"Aptos",sans-serif;}
        h1
        	{mso-style-priority:9;
        	mso-style-link:"Título 1 Caráter";
        	mso-margin-top-alt:auto;
        	margin-right:0cm;
        	mso-margin-bottom-alt:auto;
        	margin-left:0cm;
        	font-size:14.0pt;
        	font-family:"Arial",sans-serif;
        	color:#8F1512;
        	font-weight:bold;}
        h4
        	{mso-style-priority:9;
        	mso-style-link:"Título 4 Caráter";
        	mso-margin-top-alt:auto;
        	margin-right:0cm;
        	mso-margin-bottom-alt:auto;
        	margin-left:0cm;
        	font-size:12.0pt;
        	font-family:"Arial",sans-serif;
        	color:black;
        	font-weight:bold;}
        a:link, span.MsoHyperlink
        	{mso-style-priority:99;
        	color:#467886;
        	text-decoration:underline;}
        span.Ttulo1Carter
        	{mso-style-name:"Título 1 Caráter";
        	mso-style-priority:9;
        	mso-style-link:"Título 1";
        	font-family:"Aptos Display",sans-serif;
        	color:#0F4761;}
        span.Ttulo4Carter
        	{mso-style-name:"Título 4 Caráter";
        	mso-style-priority:9;
        	mso-style-link:"Título 4";
        	font-family:"Aptos",sans-serif;
        	color:#0F4761;
        	font-style:italic;}
        span.EstiloCorreioEletrnico23
        	{mso-style-type:personal-reply;
        	font-family:"Aptos",sans-serif;
        	color:windowtext;}
        .MsoChpDefault
        	{mso-style-type:export-only;
        	font-size:10.0pt;
        	mso-ligatures:none;}
        @page WordSection1
        	{size:612.0pt 792.0pt;
        	margin:70.85pt 3.0cm 70.85pt 3.0cm;}
        div.WordSection1
        	{page:WordSection1;}
        -->
    </style>
    <!--[if gte mso 9]><xml>
<o:shapedefaults v:ext="edit" spidmax="1026" />
</xml><![endif]-->
    <!--[if gte mso 9]><xml>
<o:shapelayout v:ext="edit">
<o:idmap v:ext="edit" data="1" />
</o:shapelayout></xml><![endif]-->
</head>

<body bgcolor="#5EA1CE" background="http://digital.sanipower.pt/assets/img/wg_blurred_backgrounds_11.jpg" lang=PT link="#467886" vlink="#96607D" style='word-wrap:break-word'>
    <div class=WordSection1>
        <o:p></o:p>
        </span>
        </p>
        </td>
        <td style='padding:0cm 0cm 0cm 0cm;height:30.0pt'></td>
        </tr>
        <tr>
            <td width=189 style='width:5.0cm;padding:0cm 0cm 0cm 0cm'></td>
            <td width=118 style='width:88.5pt;padding:0cm 0cm 0cm 0cm'></td>
            <td width=243 style='width:182.25pt;padding:0cm 0cm 0cm 0cm'></td>
        </tr>
        </table>
    </div>
    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Helvetica",sans-serif;mso-fareast-language:EN-US'><o:p>&nbsp;</o:p></span></p>
    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Helvetica",sans-serif;mso-fareast-language:EN-US'><o:p>&nbsp;</o:p></span></p>
    <div <o:p>
        </o:p>
        </span>
        </p>
        <div align=center>
            <table class=MsoNormalTable border=0 cellpadding=0 width=600 style='width:450.0pt;background:white'>
                <tr>
                    <td colspan=3 style='padding:.75pt .75pt .75pt .75pt'>
                        <p class=MsoNormal style='line-height:16.5pt'><span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>&nbsp;&nbsp;</span><span style='font-size:10.5pt;font-family:"Arial",sans-serif'><o:p></o:p></span></p>
                    </td>
                </tr>
                <tr>
                    <td style='padding:.75pt .75pt .75pt .75pt'>
                        <p class=MsoNormal style='line-height:16.5pt'><span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>&nbsp;&nbsp;</span><span style='font-size:10.5pt;font-family:"Arial",sans-serif'><o:p></o:p></span></p>
                    </td>
                    <td style='padding:.75pt .75pt .75pt .75pt'>
                        <p align=center style='text-align:center;line-height:16.5pt'><span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'><img border=0 width=164 height=50 style='width:1.7083in;height:.5208in' id="_x0000_i1032" src="http://digital.sanipower.pt/assets/img/sanidigital.jpg" alt=SaniDigital></span>
                            <span
                            style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                                <o:p></o:p>
                                </span>
                        </p>
                        <div class=MsoNormal align=center style='text-align:center;line-height:16.5pt'><span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'><hr size=1 width="100%" align=center></span></div>
                        <div align=center>
                            <table class=MsoNormalTable border=0 cellpadding=0 width=530 style='width:397.5pt'>
                                <tr>
                                    <td colspan=2 style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <h1 style='margin-bottom:0cm;mso-line-height-alt:10.5pt'>Relatório de Visita N. <?php echo $visita['id']; ?><o:p></o:p></h1>
                                        <p style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>Data da Visita: <?php echo $visita['data_final']; ?><br>Tipo de Visita: <?php if ($visita['id_tipo_visita'] == 2) { echo 'Comercial'; } elseif ($visita['id_tipo_visita'] == 1) { echo 'Email'; } else { echo 'Telefone'; } ?><o:p></o:p></span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=160 valign=top style='width:120.0pt;border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><b><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>Dados do cliente<o:p></o:p></span></b></p>
                                    </td>
                                    <td width=370 valign=top style='width:277.5pt;border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><?php foreach($cliente->customers as $client) { echo $client->name; ?><br><?php echo $client->address; ?><br><?php echo $client->zipcode; ?><br>NIF: <?php echo $client->nif; } ?> <o:p></o:p></span></p>
                                    </td>
                                </tr>
                                <?php 
                                if($prop_enc != null){
                                foreach($prop_enc as $item){
                                    $firstWord = explode(' ', $item->budget)[0];
                                    echo '
                                 <tr>
                                    <td style="border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt">
                                        <p class=MsoNormal style="line-height:10.5pt"><b><span style="font-size:7.0pt;font-family:Arial,sans-serif">'.$firstWord.'<o:p></o:p></span></b></p>
                                    </td>
                                    <td style="border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt">
                                        <p class=MsoNormal style="line-height:10.5pt"><span style="font-size:7.0pt;font-family:Arial,sans-serif">O cliente efetuou a '.$item->budget.' no valor de '.$item->total.'€ nesta data.<o:p></o:p></span></p>
                                    </td>
                                </tr> ';
                                } }?>
                                <tr>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><b><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>Relatório final da visita<o:p></o:p></span></b></p>
                                    </td>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><?php echo $visitComment['relatorio']; ?><o:p></o:p></span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><b><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>Pendentes para a próxima visita<o:p></o:p></span></b></p>
                                    </td>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><?php echo $visitComment['pendentes_proxima_visita']; ?><o:p></o:p></span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><b><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>Comentário sobre encomendas<o:p></o:p></span></b></p>
                                    </td>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><?php echo $visitComment['comentario_encomendas']; ?><o:p></o:p></span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><b><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>Comentário sobre propostas<o:p></o:p></span></b></p>
                                    </td>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><?php echo $visitComment['comentario_propostas']; ?><o:p></o:p></span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><b><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>Comentário sobre financeiro<o:p></o:p></span></b></p>
                                    </td>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><?php echo $visitComment['comentario_financeiro']; ?><o:p></o:p></span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><b><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>Comentário sobre ocorrências<o:p></o:p></span></b></p>
                                    </td>
                                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><?php echo $visitComment['comentario_ocorrencias']; ?><o:p></o:p></span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=2 style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal align=right style='text-align:right;line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><o:p>&nbsp;</o:p></span></p>
                                        <h4 align=right style='text-align:right;mso-line-height-alt:10.5pt'><?php echo $Utilizador->first()->name; ?><o:p></o:p></h4></td>
                                </tr>
                                <tr>
                                    <td colspan=2 style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'>&nbsp;<br></span><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><?php if ($visita['id_tipo_visita'] == 2) { echo '<img border=0 id="_x0000_i1031" src="https://com.sanipower.pt/assets/mobile/images/Presencial.png">'; } elseif ($visita['id_tipo_visita'] == 1) { echo '<img border=0 id="_x0000_i1031" src="https://com.sanipower.pt/assets/mobile/images/Email.png">'; } else { echo '<img border=0 id="_x0000_i1031" src="https://com.sanipower.pt/assets/mobile/images/Telefone.png">'; } ?></span>
                                            <span
                                            style='font-size:7.0pt;font-family:"Arial",sans-serif'>
                                                <o:p></o:p>
                                                </span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <p align=center style='text-align:center;line-height:16.5pt'><span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>&nbsp;</span><span style='font-size:10.5pt;font-family:"Arial",sans-serif'><o:p></o:p></span></p>
                        <div class=MsoNormal align=center style='text-align:center;line-height:16.5pt'><span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'><hr size=1 width="100%" align=center></span></div>
                        <table class=MsoNormalTable border=0 cellpadding=0 width="100%" style='width:100.0%'>
                            <tr>
                                <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                                    <p class=MsoNormal style='mso-line-height-alt:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><img border=0 width=440 height=226 style='width:4.5833in;height:2.3541in' id="_x0000_i1030" src="http://digital.sanipower.pt/assets/img/sanipower-footer.jpg" alt=SaniDigital></span>
                                        <span
                                        style='font-size:7.0pt;font-family:"Arial",sans-serif'>
                                            <o:p></o:p>
                                            </span>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif;color:black'>&nbsp;&nbsp;</span><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><o:p></o:p></span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan=3 style='border:none;border-bottom:solid black 1.0pt;padding:.75pt .75pt .75pt .75pt'>
                        <p class=MsoNormal style='line-height:10.5pt'><span style='font-size:7.0pt;font-family:"Arial",sans-serif;color:black'>&nbsp;&nbsp;</span><span style='font-size:7.0pt;font-family:"Arial",sans-serif'><o:p></o:p></span></p>
                    </td>
                </tr>
            </table>
        </div>
        <p style='line-height:16.5pt'><span style='font-size:10.5pt;font-family:"Arial",sans-serif'>&nbsp;<o:p></o:p></span></p>
    </div>
    </div>
    </div>
    </div>
</body>

</html>