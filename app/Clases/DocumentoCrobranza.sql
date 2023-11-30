SELECT '01'+'|'+'20604309027'+'|'+'0'+isnull(rtrim(ltrim(Documento.NumeroSerie)),'')+isnull(substring(rtrim(ltrim(Documento.NumeroDocumento)),3,8),'')+'|' +'CAL.CALLE MARQUES DE MONTESCLAROS NRO. 165 DPTO. 104 URB. LA VIRREYNA LIMA - LIMA - SANTIAGO DE SURCO'+'|'+ isnull(substring(rtrim(ltrim(convert(char,dbo.documento.fechaemision,120))),1,10),'')+'|'+isnull(substring(rtrim(ltrim(convert(char,dbo.documento.FechaVencimiento,120))),1,10),'')+'|'+CASE WHEN isnull(Documento.Moneda,'') = 'SOL' THEN 'PEN' ELSE isnull(Documento.Moneda,'') END+'|' +
	isnull(convert(varchar(1),EquivalenteDocIdSunat.TipoDocumentoSunat),'')+ '|'+isnull(rtrim(ltrim(dbo.documento.NroDocumentoIdentidad)),'')+'|'+isnull(rtrim(ltrim(Documento.RazonSocial)),'')+'|'+isnull(rtrim(ltrim(Documento.Direccion1)),'')+'|'+isnull(dbo.ClienteEmail.Email,'')+
	 '|'+CASE WHEN isnull(convert(varchar(1),dbo.DevuelveFormaPago(@IdDoc)),'') = '1' THEN 
	case when cast( dbo.Documento.FechaEmision as date) = cast(dbo.Documento.FechaVencimiento as date) then 'CANCELADO/CONTADO' else 'CREDITO' end
WHEN isnull(convert(varchar(1),dbo.DevuelveFormaPago(@IdDoc)),'') = '2' THEN 
	'TARJETA DE CREDITO'
else
	'  '
end+'|'+dbo.CantidadConLetra(Documento.NetoDocumento+Documento.ImpuestoDocumento+Documento.OtrosImpuestosDocumento, Documento.Moneda)+'|'+
	 +case when isnull(documento.GlosaDocumento,'') ='' then 'SOLICITADO POR: ' else ' ' end + case when isnull(documento.GlosaDocumento,'') ='' then isnull((
	 select top 1 ti.SolicitanteTicket
	 from DocumentoDetalle dd1 , Ticket ti 
	 where documento.IdDocumento = dd1.IdDocumento
			and  dd1.IdTicket = ti.IdTicket ),'') else ' ' end +
	 
	   +'|'+isnull((select top 1 ti.Codigo19  from ticket ti , DocumentoDetalle dd where dd.IdDocumento = documento.IdDocumento and ti.IdTicket = dd.idticket),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,3),Documento.MontoCambio)),'')+'|'+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.ImpuestoDocumento)),'')+'|'+case when dbo.Documento.AfectoDocumento > 0 then '18.00' else '0.00' end+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.OtrosImpuestosDocumento)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.afectoDocumento)),'')+'|'+'0.00'+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.NetoDocumento+Documento.ImpuestoDocumento+Documento.OtrosImpuestosDocumento)),'')+'|'+'0.00'+'|'
	   +dbo.InicialesUsuario(@IdDoc)+'      '+dbo.InicialesVendedor(@IdDoc)+'      '+dbo.InicialesCounter(@IdDoc)+'|'+case when isnull(documento.GlosaDocumento,'') ='' then  'POR LA COMPRA DE BOLETO(S) AEREOS A FAVOR DE:' ELSE '' end+'|'
	   +isnull(convert(varchar(19),ti.codigo01),'')+' '+isnull(convert(varchar(19),ti.codigo02),'')+'|'+'|'
	   /*+'|'+'|'*/
	   +'|'+ cliente.TelefonoCliente+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.InafectoDocumento)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.ExoneradoDocumento)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),Documento.NetoDocumento)),'')+'|' as dato1, 
	'20604309027' as ruc,
	Documento.TipoDocumento as tipodocumento, 
	case when rtrim(ltrim(dbo.Documento.TipoDocumento)) = 36 then 'DC-D' else '' end+isnull(Documento.NumeroSerie,'') as numeroserie,
		isnull(Documento.NumeroDocumento,'') as numerodocumento 

	--PRIMERO ES ruc, luego dato2, luego numeroserie y luego numerodocumento

FROM Documento left join clienteEmail  on Documento.IdCliente =clienteEmail.IdCliente, cliente, EquivalenteDocIdSunat, ticket ti ---1 se agrega las otras tablas:
WHERE Documento.IdCliente =cliente.IdCliente and Documento.IdDocumento = ti.IdDocumento
and cliente.IdDocumentoIdentidad = EquivalenteDocIdSunat.TipoDocumentoSistema ---2 se hace la union entre las 2 tablas  x la clave.
and Documento.IdDocumento = @IdDoc

SELECT '02'+'|'+CAST(ROW_NUMBER() OVER(PARTITION BY dd.iddocumento ORDER BY dd.iddocumento ASC) as varchar(20))+'|'+'20604309027'+'|'+'0'+isnull(rtrim(ltrim(Documento.NumeroSerie)),'')+isnull(substring(rtrim(ltrim(Documento.NumeroDocumento)),3,8),'')+'|'+'|'+'|'+ case when isnull(documento.GlosaDocumento,'') <>'' then documento.GlosaDocumento else (CASE dd.IdTipoDetalle WHEN 1 THEN dbo.fx_obtiene_glosaDC(documento.IdDocumento, dd.IdDocumentoDetalle) ELSE NombreTipoDetalle END)  end +
	+ '|'+'1.00'+
	 '|'+isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),ImpuestoDocumentoDetalle)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2), OtrosImpuestosDocumentoDetalle)),'')+'|'+'18.00'+'|'+'0.00'+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle+dd.ImpuestoDocumentoDetalle+dd.OtrosImpuestosDocumentoDetalle)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle)),'')+'|'+isnull(convert(varchar(19),Convert(Decimal(18,2),dd.NetoDocumentoDetalle+dd.ImpuestoDocumentoDetalle+dd.OtrosImpuestosDocumentoDetalle)),'')
	 +'|' as dato1, 
	
	'20604309027' as ruc,
	Documento.TipoDocumento as tipodocumento, 
	isnull(Documento.NumeroSerie,'') as numeroserie, 
	isnull(Documento.NumeroDocumento,'') as numerodocumento 

	--PRIMERO ES ruc, luego dato2, luego numeroserie y luego numerodocumento



from documento, DbnetOffice.dbo.DocumentoDetalle dd INNER JOIN Ticket ti ON dd.IdTicket = ti.IdTicket 
      INNER JOIN TipoDetalle tl ON dd.IdTipoDetalle = tl.IdTipoDetalle               
      INNER JOIN TipoServicio ts ON ti.IdTipoServicio = ts.IdTipoServicio 
where dd.IdDocumento = @IdDoc
and documento.IdDocumento = dd.IdDocumento