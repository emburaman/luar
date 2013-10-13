create view vLr_rel_acesso_usuario_tela as 
  select ra.username, 
         ra.id_tela, 
         ra.cod_nivel_acesso, 
         tl.nome              nome_tela
  from   lr_tela                    tl, 
         lr_rel_acesso_usuario_tela ra
  where  ra.id_tela = tl.id_tela;