<html>
<style>
body,td{font-family:arial;font-size:14px;line-height:22px;color:rgba(0,0,0,0.55)}
td { font-size: 11px }
.direita { text-align: right; }
.copy {font-size:12px!important;line-height:18px;}
</style>
<body style="background:#5ea1ce url('http://digital.sanipower.pt/assets/img/wg_blurred_backgrounds_11.jpg');">
	<p>&nbsp;</p>
	<table width="600" align="center" style="width:600px;margin:0 auto;background:#fff;" background="#fff">
		<tr>
			<td colspan="3">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;</td>
			<td>
				<p align="center"><img src="http://digital.sanipower.pt/assets/img/sanidigital.jpg" alt="SaniDigital" title="SaniDigital"></p>
				<hr>
				<p><?php echo $ocorrenciaArray[0]->document; ?> Nº<?php echo $ocorrenciaArray[0]->document_number; ?> registadas para o cliente - <?php echo $ocorrenciaArray[0]->customer_name; ?> Nº<?php echo $ocorrenciaArray[0]->customer_number; ?>.<br>&nbsp;<br><?php echo $ocorrenciaArray[0]->type_1; ?> | <?php echo $ocorrenciaArray[0]->type_2; ?></p>
				<hr>
				<table width="100%" style="width:100%;">	
					<tr>
						<td ><img src="http://digital.sanipower.pt/assets/img/sanipower-footer.jpg" alt="SaniDigital" title="SaniDigital"></td>
					</tr>
				</table>
			</td>
			<td>&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;&nbsp;</td>
		</tr>	
	</table>
	<p>&nbsp;</p>
</body>
</html>
