create view vLr_voluntario as 
  select vo.id_voluntario  id_voluntario, 
         vo.nome           nome_voluntario, 
         tv.descricao      desc_tipo_voluntario,
         nu.descricao      desc_nucleo, 
         vo.bairro         bairro, 
         vo.telefone       telefone, 
         vo.email          email,
         en.descricao      desc_entidade,
         us.username       username
  from   lr_tipo_voluntario tv,
         lr_usuario         us,
         lr_nucleo          nu,
         lr_entidade        en,
         lr_voluntario      vo
  where  en.id_entidade        = vo.id_entidade and 
         nu.id_nucleo          = vo.id_nucleo   and 
         us.username           = vo.username  and 
         tv.id_tipo_voluntario = vo.id_tipo_voluntario;