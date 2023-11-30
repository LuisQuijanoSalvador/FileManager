SELECT '01'+'|'+'20604309027'
+'|'+'AS TRAVEL PERU SAC'
+'|' +'CAL.CALLE MARQUES DE MONTESCLAROS NRO. 165 DPTO. 104 URB. LA VIRREYNA LIMA - LIMA - SANTIAGO DE SURCO'
+'|'+ isnull(substring(rtrim(ltrim(convert(char,dbo.documento.fechaemision,120))),1,10),'')
+'|'+isnull(substring(rtrim(ltrim(convert(char,dbo.documento.FechaVencimiento,120))),1,10),'')
+'|'+'01'
+'|'+'0'
+'|'+isnull(rtrim(ltrim(dbo.Documento.TipoDocumento)),'')
+'|'+case when rtrim(ltrim(dbo.Documento.TipoDocumento)) <> '03' then 'F' else 'B' end+isnull(rtrim(ltrim(Documento.NumeroSerie)),'')
+isnull(substring(rtrim(ltrim(Documento.NumeroDocumento)),3,8),'')
+'|'+case when dbo.Documento.TipoDocumento='07' then'01' else '' end
+'|'+case when dbo.Documento.TipoDocumento='07' then ti.codigo15 else '' end
+'|'+case when dbo.Documento.TipoDocumento='07' then'01' else '' end
+'|'+case when dbo.Documento.TipoDocumento='07' then 'anulacion de operación' else '' end
+'|'+isnull(convert(varchar(1),EquivalenteDocIdSunat.TipoDocumentoSunat),'')
+'|'+isnull(rtrim(ltrim(dbo.documento.NroDocumentoIdentidad)),'')
+'|'+isnull(rtrim(ltrim(EquivalenteDocIdSunat.DescripCorta)),'')
+'|'+isnull(rtrim(ltrim(Documento.RazonSocial)),'')
+'|'+isnull(rtrim(ltrim(Documento.Direccion1)),'')
+'|'+ CASE WHEN isnull(Documento.Moneda,'') = 'SOL' THEN 'PEN' ELSE isnull(Documento.Moneda,'') END +'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.NetoDocumento)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.ExoneradoDocumento)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.InafectoDocumento)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.AfectoDocumento)),'')+'|'+'0.00'+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.ImpuestoDocumento)),'')+
	+'|'+'0.00'+ '|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.NetoDocumento+Documento.ImpuestoDocumento+Documento.OtrosImpuestosDocumento)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.OtrosImpuestosDocumento)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.ImpuestoEspecial)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.DescuentoDocumento)),'')+'|'+'0.00'+'|'+'0.00'+'|'+'0.00'+
	'|'+'0.00'+'|'+dbo.CantidadConLetra(Documento.NetoDocumento+Documento.ImpuestoDocumento+Documento.OtrosImpuestosDocumento, Documento.Moneda)+'|'+'0.00'+'|'+'0.00'+'|'+'0.00'+'|'+'0.00'+'|'+'0.00'+'|'+'|'+'18.00'+'|'+isnull(convert(varchar(19),Convert(Decimal(18,3),Documento.MontoCambio)),'')+'|'   as dato1, 
	
	'20604309027' as ruc,
	LTRIM(RTRIM(Documento.TipoDocumento)) as tipodocumento, 
	case when rtrim(ltrim(dbo.Documento.TipoDocumento)) <> '03' then 'F' else 'B' end+isnull(LTRIM(RTRIM(Documento.NumeroSerie)),'') as numeroserie, 
	isnull(RIGHT(Documento.NumeroDocumento,8),'') as numerodocumento 

	

FROM ticket ti, Documento , cliente, EquivalenteDocIdSunat ---1 se agrega las otras tablas:
WHERE Documento.IdCliente =cliente.IdCliente
and cliente.IdDocumentoIdentidad = EquivalenteDocIdSunat.TipoDocumentoSistema ---2 se hace la union entre las 2 tablas  x la clave.
and Documento.IdDocumento = @IdDoc
and ti.IdDocumento = Documento.IdDocumento
/*and (Documento.NumeroDocumento = @v_numero)
and Documento.NumeroSerie  = @v_serie
and Documento.IdTipoDocumento = @v_tipo*/
SELECT '02'+'|'+
isnull(dbo.ClienteEmail.Email,'')+'|'+
isnull(dbo.ClienteEmail.copiaEmail,'')+'|'+
isnull(convert(varchar(4),dbo.Documento.IdCliente),'')+
'|'+'|'+'|'+'|'+'|'+'|'+'|'+'|'+'|'+'|'+ CASE WHEN isnull(convert(varchar(1),dbo.DevuelveFormaPago(@IdDoc)),'') = '1' THEN 
	case when cast( dbo.Documento.FechaEmision as date) = cast(dbo.Documento.FechaVencimiento as date) then 'CANCELADO/CONTADO' else 'CREDITO' end
WHEN isnull(convert(varchar(1),dbo.DevuelveFormaPago(@IdDoc)),'') = '2' THEN 
	'TARJETA DE CREDITO'
else
	'  '
-- end+'|'+ cliente.TelefonoCliente+'|'+'|'+'|'+'|'+'|'+'|'+isnull((select top 1 ti.Codigo19  from ticket ti , DocumentoDetalle dd where dd.IdDocumento = documento.IdDocumento and ti.IdTicket = dd.idticket),'') +'|'+'|'+dbo.InicialesUsuario(@IdDoc)+'      '+dbo.InicialesVendedor(@IdDoc)+'      '+dbo.InicialesCounter(@IdDoc)+'|'+'|'+case when isnull(documento.GlosaDocumento,'') <>'' then documento.GlosaDocumento else dbo.fx_obtiene_SOLICITADOpor(@IdDoc) + ' POR LA EMISION DE BOLET(O)S AEREOS A FAVOR DE:                                                                        ' end +case when isnull(documento.GlosaDocumento,'') <>'' then '  ' else dbo.fx_obtiene_glosa(@IdDoc) end  +'|'+'|'+'|' 
end+'|'+ cliente.TelefonoCliente+'|'+'|'+'|'+'|'+'|'+'|'+isnull((select top 1 ti.Codigo19  from ticket ti , DocumentoDetalle dd where dd.IdDocumento = documento.IdDocumento and ti.IdTicket = dd.idticket),'') +'|'+ CASE WHEN ti.codigo15 = 'DETRA' THEN 'OPERACION SUJETA AL SISTEMA DE PAGO DE OBLIGACIONES TRIBUTARIAS CON EL GOBIERNO CENTRAL BANCO DE LA NACION: 00058327778' ELSE '' END +'|'+dbo.InicialesUsuario(@IdDoc)+'      '+dbo.InicialesVendedor(@IdDoc)+'      '+dbo.InicialesCounter(@IdDoc)+'|'+isnull(convert(varchar(19),ti.codigo01),'')+' '+isnull(convert(varchar(19),ti.codigo02),'')+'|'+case when isnull(documento.GlosaDocumento,'') <>'' then documento.GlosaDocumento else dbo.fx_obtiene_SOLICITADOpor(@IdDoc) + ' POR LA EMISION DE BOLET(O)S AEREOS                                                                         ' end   +'|'+'|'--+'|' Validar Ubicacion segun numero de campos nuevo
/*27*/ +'|0000'
/*28*/ +'|0101'
/*29*/ +'|1900-01-01'
/*30*/ +'|'
/*31*/ +'|'
/*32*/ +'|'
/*33*/ +'|'
/*34*/ +'|'
/*35*/ +'|'
/*36*/ +'|'
/*37*/ +'|'
/*38*/ +'|0.00'
/*39*/ +'|'+ LEFT(CAST(ROUND(NetoDocumento,2) AS varchar),LEN(CAST(ROUND(NetoDocumento,2) AS varchar))-2)
/*40*/ +'|'+ LEFT(CAST(ROUND(NetoDocumento+ImpuestoDocumento,2) AS varchar),LEN(CAST(ROUND(NetoDocumento+ImpuestoDocumento,2) AS varchar))-2)
/*41*/ +'|'
/*42*/ +'|'
/*43*/ +'|0.00'
/*44*/ +'|0.00'
/*45*/ +'|'
/*46*/ +'|0.00'
/*47*/ +'|0.00'
/*48*/ +'|' + ISNULL(ti.Codigo07,'')
/*49*/ +'|' + ISNULL(ti.Codigo08,'')
/*50*/ +'|'+ LEFT(CAST(ROUND(NetoDocumento+ImpuestoDocumento,2) AS varchar),LEN(CAST(ROUND(NetoDocumento+ImpuestoDocumento,2) AS varchar))-2)
/*51*/ +'|'
/*52*/ +'|'
/*53*/ +'|'
/*54*/ +'|'
/*55*/ +'|'
/*56*/ +'|'
/*57*/ +'|'
/*58*/ +'|'
/*59*/ +'|0'
/*60*/ +'|0.00'
/*61*/ +'|0.00'
/*62*/ +'|'
/*63*/ +'|'
/*64*/ +'|0.00'
/*65*/ +'|0.00'
/*66*/ +'|'
/*67*/ +'|'
/*68*/ +'|'
/*69*/ +'|'
/*70*/ +'|1900-01-01'
/*71*/ +'|'
/*72*/ +'|'
/*73*/ +'|0.00'
/*74*/ +'|pen'
/*75*/ +'|0'
/*76*/ +'|'
/*77*/ +'|0.00'
/*78*/ +'|'
/*79*/ +'|1900-01-01'
/*80*/ +'|'
/*81*/ +'|'
/*82*/ +'|'
/*83*/ +'|'
/*84*/ +'|'
/*85*/ +'|'
/*86*/ +'|'
/*87*/ +'|'
/*88*/ +'|'
/*89*/ +'|'
/*90*/ +'|'
/*91*/ +'|'
/*92*/ +'|'
/*93*/ +'|'
/*END*/+'|'



as dato2

FROM Documento left join clienteEmail  on Documento.IdCliente =clienteEmail.IdCliente, Cliente, Ticket ti
WHERE documento.IdDocumento = @IdDoc  
and documento.IdDocumento = ti.IdDocumento --<---esto no estaba estaba jalando todos los documentos.
and Documento.IdCliente = Cliente.IdCliente


select 
'03'
+'|'+CAST(ROW_NUMBER() OVER(PARTITION BY dd.iddocumento ORDER BY dd.iddocumento ASC) as varchar(20))
+'|'+'0'
+'|'+isnull(convert(varchar(20), dd.IdTipoDetalle ),'')
+'|'+(CASE dd.IdTipoDetalle WHEN 1 THEN ts.DescripcionServicio ELSE NombreTipoDetalle END)+', '+
case when isnull(doc.GlosaDocumento,'') <>'' then '  ' else dbo.fx_obtiene_descripcion_Item_Fact(@IdDocumento, idDocumentodetalle)+' TKT: '+ ti.codigo18 +'-'+ti.codigo20+ ' EN '+ ti.Codigo17 end 
+'|'+convert(varchar(20),Convert(Decimal(18,2),1))
+'|'+'zz'
+ '|'+CASE WHEN dd.ImpuestoDocumentoDetalle = 0 THEN convert(varchar(20),30)+ '|' ELSE convert(varchar(20),10)+ '|' END +
CASE WHEN dd.ImpuestoDocumentoDetalle = 0 THEN convert(varchar(20),9998)+ '|' ELSE convert(varchar(20),1000)+ '|' END +
--isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle)),' ')+ '|' + 
--isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle)),' ')+ '|' +
CASE WHEN dd.InafectoDocumentoDetalle > 0 THEN isnull(convert(varchar(19),Convert(Decimal(18,2),dd.InafectoDocumentoDetalle)),' ') ELSE isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle)),' ') END + '|' + 
CASE WHEN dd.InafectoDocumentoDetalle > 0 THEN isnull(convert(varchar(19),Convert(Decimal(18,2),dd.InafectoDocumentoDetalle)),' ') ELSE isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle)),' ') END + '|' + 
'0.00'+'|'+
'0.00'+'|'+
isnull(convert(varchar(19),Convert(Decimal(18,2),dd.ImpuestoDocumentoDetalle)),' ')+'|'+
'0.00'+'|'+
'01'+'|'+
CASE WHEN dd.InafectoDocumentoDetalle > 0 THEN isnull(convert(varchar(19),Convert(Decimal(18,2),dd.InafectoDocumentoDetalle+dd.ImpuestoDocumentoDetalle)),'') ELSE isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle+dd.ImpuestoDocumentoDetalle)),'') END + '|'+
CASE WHEN dd.InafectoDocumentoDetalle > 0 THEN isnull(convert(varchar(19),Convert(Decimal(18,2),dd.InafectoDocumentoDetalle+dd.ImpuestoDocumentoDetalle)),'') ELSE isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle+dd.ImpuestoDocumentoDetalle)),'') END + '|'+
CASE WHEN dd.InafectoDocumentoDetalle > 0 THEN isnull(convert(varchar(19),Convert(Decimal(18,2),dd.InafectoDocumentoDetalle)),'') ELSE isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle)),'') END + '|' + 
CASE WHEN dd.InafectoDocumentoDetalle > 0 THEN isnull(convert(varchar(19),Convert(Decimal(18,2),dd.InafectoDocumentoDetalle)),'') ELSE isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle)),'') END + '|' +
CASE WHEN dd.InafectoDocumentoDetalle > 0 THEN isnull(convert(varchar(19),Convert(Decimal(18,2),dd.InafectoDocumentoDetalle+dd.ImpuestoDocumentoDetalle+dd.OtrosImpuestosDocumentoDetalle)),'') ELSE isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle+dd.ImpuestoDocumentoDetalle+dd.OtrosImpuestosDocumentoDetalle)),'') END
/*21*/+'|'
/*22*/+'|'
/*23*/+'|'
/*24*/+'|'
/*25*/+'|0.00'
/*26*/+'|0.00'
/*27*/+'|0.00'
/*28*/+'|0.00'
/*29*/+'|0.00'
/*30*/+'|0.00'
/*31*/+'|18.00'
/*32*/+'|'
/*33*/+'|'
/*34*/+'|'
/*35*/+'|'
/*36*/+'|'
/*37*/+'|1900-01-01'
/*38*/+'|1900-01-01'
/*39*/+'|1900-01-01'
/*40*/+'|1900-01-01'
/*41*/+'|0'
/*42*/+'|0101'
/*43*/+'|'+ltrim(rtrim(convert(char,doc.FechaEmision ,23)))
/*END*/+'|'

as dato1

from   Documento doc, DbnetOffice.dbo.DocumentoDetalle dd INNER JOIN Ticket ti ON dd.IdTicket = ti.IdTicket 
      INNER JOIN TipoDetalle tl ON dd.IdTipoDetalle = tl.IdTipoDetalle               
      INNER JOIN TipoServicio ts ON ti.IdTipoServicio = ts.IdTipoServicio 
where dd.IdDocumento = @IdDocumento 
and doc.IdDocumento = dd.IdDocumento