
delete from lr_status;

INSERT INTO `lr_status` (`id_status`, `descricao`) VALUES
(1, 'ATIVO'),
(2, 'INATIVO'), 
(3, 'INCONSITENTE');

--
-- Inserindo `lr_entidade`
--

insert into lr_entidade (descricao) values ('Igreja Metodista Livre - Sorocaba');

--
-- Inserindo `lr_tipo_voluntario`
--

insert into lr_tipo_voluntario (descricao) values ('Administrador');
insert into lr_tipo_voluntario (descricao) values ('Coordenador');
insert into lr_tipo_voluntario (descricao) values ('Captador');
insert into lr_tipo_voluntario (descricao) values ('Coletor');
insert into lr_tipo_voluntario (descricao) values ('Digitador');

--
-- Table structure for table `lr_tela`
--

insert into lr_tela (nome) values ('FRM_VOLUNTARIO');
insert into lr_tela (nome) values ('FRM_NUCLEO');
insert into lr_tela (nome) values ('FRM_EMPRESA');
insert into lr_tela (nome) values ('FRM_USUARIO');
insert into lr_tela (nome) values ('FRM_ENTIDADE');
insert into lr_tela (nome) values ('FRM_IMPORTACAO');


--
-- Inserindo lr_config_acesso_tipo_volunt
--
insert into lr_config_acesso_tipo_volunt values (1, 1, 'T');
insert into lr_config_acesso_tipo_volunt values (1, 2, 'T');
insert into lr_config_acesso_tipo_volunt values (1, 3, 'T');
insert into lr_config_acesso_tipo_volunt values (1, 4, 'T');
insert into lr_config_acesso_tipo_volunt values (1, 5, 'T');
insert into lr_config_acesso_tipo_volunt values (1, 6, 'T');
insert into lr_config_acesso_tipo_volunt values (2, 1, 'T');
insert into lr_config_acesso_tipo_volunt values (2, 2, 'C');
insert into lr_config_acesso_tipo_volunt values (2, 3, 'T');
insert into lr_config_acesso_tipo_volunt values (3, 1, 'C');
insert into lr_config_acesso_tipo_volunt values (3, 2, 'C');
insert into lr_config_acesso_tipo_volunt values (3, 3, 'C');
insert into lr_config_acesso_tipo_volunt values (4, 1, 'C');
insert into lr_config_acesso_tipo_volunt values (4, 2, 'C');
insert into lr_config_acesso_tipo_volunt values (4, 3, 'C');

--
--
-- Inserindo `lr_nucleo`
--

insert into lr_nucleo (descricao) values ('ENEIDA ALQUATI');
insert into lr_nucleo (descricao) values ('SUELI YOSIDA');
insert into lr_nucleo (descricao) values ('IVETE RINALDI');
insert into lr_nucleo (descricao) values ('MIDORI NAGAHARA');
insert into lr_nucleo (descricao) values ('CARLOS AMENDOEIRA');

--
--
-- Inserindo `lr_status_nota`
--
insert into lr_status_nota (cod_status_nota, descricao) values ('CADASTRADA', 'Aguardando registro da nota pelo estabelecimento');
insert into lr_status_nota (cod_status_nota, descricao) values ('DOC_ENCONTRADO', 'Pedido com documento encontrado');
insert into lr_status_nota (cod_status_nota, descricao) values ('DOC_NAO_ENCONTRADO', 'Não foi possível encontrar o documento com as informações digitadas');
insert into lr_status_nota (cod_status_nota, descricao) values ('DOC_DESTINATARIO', 'Documento encontrado com destinatário.Não pode ser doado.');
insert into lr_status_nota (cod_status_nota, descricao) values ('CREDITO_LIBERADO', 'Crédito Liberado');
     
--
-- Inserindo lr_rel_acesso_usuario_tela
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('rysimizu', 1, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('rysimizu', 2, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('rysimizu', 3, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('rysimizu', 4, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('rysimizu', 5, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('rysimizu', 6, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('emburaman', 1, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('emburaman', 2, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('emburaman', 3, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('emburaman', 4, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('emburaman', 5, 'T');
--
insert into lr_rel_acesso_usuario_tela (username, id_tela, cod_nivel_acesso)
                                values ('emburaman', 6, 'T');
--