create view vLr_acesso_tela_usuario as 
  select tl.id_tela as nome_tela,
         cf.*
  from   lr_tela tl, 
         lr_config_acesso_tipo_volunt cf;