<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns="http://www.w3.org/TR/REC-html40">
   <head>
      <meta http-equiv=Content-Type content="text/html; charset=utf-8">
      <meta name=Generator content="Microsoft Word 15 (filtered medium)">
      <style>
         <!--
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
            h2
            	{mso-style-priority:9;
            	mso-style-link:"Título 2 Caráter";
            	mso-margin-top-alt:auto;
            	margin-right:0cm;
            	mso-margin-bottom-alt:auto;
            	margin-left:0cm;
            	font-size:18.0pt;
            	font-family:"Aptos",sans-serif;
            	font-weight:bold;}
            a:link, span.MsoHyperlink
            	{mso-style-priority:99;
            	color:#467886;
            	text-decoration:underline;}
            span.Ttulo2Carter
            	{mso-style-name:"Título 2 Caráter";
            	mso-style-priority:9;
            	mso-style-link:"Título 2";
            	font-family:"Aptos Display",sans-serif;
            	color:#0F4761;}
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
   </head>
   <body bgcolor="#5EA1CE" background="http://digital.sanipower.pt/assets/img/wg_blurred_backgrounds_11.jpg" lang=PT link="#467886" vlink="#96607D" style='word-wrap:break-word'>
         <div align=center>
            <table class=MsoNormalTable border=0 cellspacing=3 cellpadding=0 width=600 style='width:450.0pt;background:white'>
               <tr>
                  <td colspan=3 style='padding:.75pt .75pt .75pt .75pt'>
                     <p class=MsoNormal style='line-height:16.5pt'>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>&nbsp;&nbsp;</span>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                           <o:p></o:p>
                        </span>
                     </p>
                  </td>
               </tr>
               <tr>
                  <td style='padding:.75pt .75pt .75pt .75pt'>
                     <p class=MsoNormal style='line-height:16.5pt'>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>&nbsp;&nbsp;</span>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                           <o:p></o:p>
                        </span>
                     </p>
                  </td>
                  <td style='padding:.75pt .75pt .75pt .75pt'>
                     <p align=center style='text-align:center;line-height:16.5pt'>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'><img border=0 width=164 height=50 style='width:1.7083in;height:.5208in' id="_x0000_i1045" src="http://digital.sanipower.pt/assets/img/sanidigital.jpg" alt=SaniDigital></span>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                           <o:p></o:p>
                        </span>
                     </p>
                     <div class=MsoNormal align=center style='text-align:center;line-height:16.5pt'>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>
                           <hr size=2 width="100%" align=center>
                        </span>
                     </div>
                     <h2 align=center style='text-align:center;mso-line-height-alt:16.5pt'>
                        <span style='font-family:"Arial",sans-serif;color:black'>Reclamação de cliente</span>
                        <span style='font-family:"Arial",sans-serif'>
                           <o:p></o:p>
                        </span>
                     </h2>
                     <p style='line-height:16.5pt'>
                        <strong><span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>Nome do cliente:</span></strong><span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'><?php echo $ocorrenciaArray[0]->customer_name; ?><br><strong><span style='font-family:"Arial",sans-serif'>Data da reclamação:</span></strong> <?php echo $ocorrenciaArray[0]->date; ?><br><strong><span style='font-family:"Arial",sans-serif'>Vendedor:</span></strong> <a href="<?php echo $ocorrenciaArray[0]->email; ?>"><?php echo $ocorrenciaArray[0]->email; ?></a><br><strong><span style='font-family:"Arial",sans-serif'>N.º Fatura:</span></strong> <?php echo $ocorrenciaArray[0]->details[0]->invoice_number; ?><br><strong><span style='font-family:"Arial",sans-serif'>Produtos:</span></strong> <?php foreach($ocorrenciaArray[0]->lines as $line){ echo $line->description.'; ';} ?><br><strong><span style='font-family:"Arial",sans-serif'>Descrição:</span></strong> <?php echo $ocorrenciaArray[0]->description; ?><br><strong><span style='font-family:"Arial",sans-serif'>Motivo:</span></strong> <?php echo $ocorrenciaArray[0]->type_1; ?> | <?php echo $ocorrenciaArray[0]->type_2; ?></span>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                           <o:p></o:p>
                        </span>
                     </p>
                     <p align=center style='text-align:center;line-height:16.5pt'>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>&nbsp;</span>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                           <o:p></o:p>
                        </span>
                     </p>
                     <div class=MsoNormal align=center style='text-align:center;line-height:16.5pt'>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>
                           <hr size=2 width="100%" align=center>
                        </span>
                     </div>
                     <table class=MsoNormalTable border=0 cellspacing=3 cellpadding=0 width="100%" style='width:100.0%'>
                        <tr>
                           <td style='padding:.75pt .75pt .75pt .75pt'>
                              <p class=MsoNormal style='line-height:16.5pt'>
                                 <span style='font-size:10.5pt;font-family:"Arial",sans-serif'><img border=0 width=440 height=226 style='width:4.5833in;height:2.3541in' id="_x0000_i1044" src="http://digital.sanipower.pt/assets/img/sanipower-footer.jpg" alt=SaniDigital></span>
                                 <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                                    <o:p></o:p>
                                 </span>
                              </p>
                           </td>
                        </tr>
                     </table>
                  </td>
                  <td style='padding:.75pt .75pt .75pt .75pt'>
                     <p class=MsoNormal style='line-height:16.5pt'>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>&nbsp;&nbsp;</span>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                           <o:p></o:p>
                        </span>
                     </p>
                  </td>
               </tr>
               <tr>
                  <td colspan=3 style='padding:.75pt .75pt .75pt .75pt'>
                     <p class=MsoNormal style='line-height:16.5pt'>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif;color:black'>&nbsp;&nbsp;</span>
                        <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
                           <o:p></o:p>
                        </span>
                     </p>
                  </td>
               </tr>
            </table>
         </div>
         <p style='line-height:16.5pt'>
            <span style='font-size:10.5pt;font-family:"Arial",sans-serif'>
               &nbsp;
               <o:p></o:p>
            </span>
         </p>
      </div>
   </body>
</html>