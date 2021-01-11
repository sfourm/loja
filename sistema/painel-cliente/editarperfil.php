<?php
@session_start();

$id_venda = @$_GET['id_venda'];
$id_usuario = @$_SESSION['id_usuario'];
$nome_usuario = @$_SESSION['nome_usuario'];
//$cpf_usuario = @$_SESSION['cpf_usuario'];
$email_usuario = @$_SESSION['email_usuario'];
$total = 0;
$frete_correios;

$res = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$cpf_usuario = $dados[0]['cpf'];

$res = $pdo->query("SELECT * from clientes where cpf = '$cpf_usuario'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$telefone = $dados[0]['telefone'];
$rua = $dados[0]['rua'];
$numero = $dados[0]['numero'];
$bairro = $dados[0]['bairro'];
$complemento = $dados[0]['complemento'];
$cep = $dados[0]['cep'];
$cidade = $dados[0]['cidade'];
$estado = $dados[0]['estado'];
?>
<section class="editar-perfil pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Editar Perfil</h2>
            </div>
            
            <div class="col-12 editar-perfil__tab justify-content-center">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                        aria-selected="false">Dados Pessoais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                        aria-selected="false">Endereços</a>
                    </li>

                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                        aria-selected="false">Trocar Email/Senha<span></span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div class="editar-perfil__tab__desc">
                            <div class="container align-items-center">
                                <div class="row pt-5 ">
                                    <div class="modal-content">
                                        <div class="pb-3 pt-3 ">
                                            <h4 class="text-center" id="exampleModalLabel">Editar Dados Pessoais</h4>
                                        </div>
                                        <form id="form-dados" method="POST">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="form-group col-12 row">
                                                        <div class="col-6"> <label>Nome</label> <input value="<?php echo @$nome_usu ?>" type="text" class="form-control" id="nome-usuario" name="nome-usuario" placeholder="Nome"> </div>
                                                        <div class="col-6"> <label>Sobrenome</label> <input value="<?php echo @$sobrenome_usu ?>" type="text" class="form-control" id="sobrenome-usuario" name="sobrenome-usuario" placeholder="Sobrenome"> </div>
                                                        <div class="col-6 pt-3"> <label>CPF</label> <input value="<?php echo @$cpf_usu ?>" type="text" class="form-control" id="cpf-usuario" name="cpf-usuario" placeholder="CPF"> </div>
                                                        <div class="col-6 pt-3"> <label>Telefone</label> <input value="<?php echo @$telefone_usu ?>" type="text" class="form-control" id="telefone-usuario" name="telefone-usuario" placeholder="Telefone"> </div>
                                                    </div>
                                                    <div id="mensagem-dados" class="text-center col-12"></div> 
                                                </div>
                                            </div>
                                            <div class="modal-footer"> 
                                                <label class="pr-4">
                                                    <input type="checkbox" name="confirmar" id="confirmar" required> Deseja realmente alterar seus dados?
                                                </label>
                                                <input value="<?php echo $_SESSION['id_usuario'] ?>" type="hidden" name="txtid" id="txtid"> 
                                                <input value="<?php echo $_SESSION['cpf_usuario'] ?>" type="hidden" name="antigo" id="antigo"> 
                                                <button type="submit" name="btn-salvar-dados" id="btn-salvar-perfil" class="btn btn-dark">Salvar</button> 
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                        <div class="editar-perfil__tab__desc">
                            <div class="container align-items-center">
                                <div class="row pt-5 ">
                                    <div class="modal-content">
                                        <div class="pb-3 pt-3 ">
                                            <h4 class="text-center" id="exampleModalLabel">Editar Endereço</h4>
                                            
                                        </div>
                                        <form id="form-endereco" method="POST">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="checkout__input">
                                                            <p>Rua<span>*</span></p>
                                                            <input type="text" value="<?php echo $rua ?>" name="rua" id="rua" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="checkout__input">
                                                            <p>Número<span>*</span></p>
                                                            <input type="text" value="<?php echo $numero ?>" name="numero" id="numero" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="checkout__input">
                                                            <p>Bairro<span>*</span></p>
                                                            <input type="text" value="<?php echo $bairro ?>" name="bairro" id="bairro" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-4 pb-3">
                                                    <div class="col-lg-4">
                                                        <div class="checkout__input">
                                                            <p>Complemento<span></span></p>
                                                            <input type="text" value="<?php echo $complemento ?>" name="complemento" id="complemento">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="checkout__input">
                                                            <p>CEP<span>*</span></p>
                                                            <input type="text" value="<?php echo $cep ?>" name="cep" id="cep" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="checkout__input">
                                                            <p>Cidade<span>*</span></p>
                                                            <input type="text" value="<?php echo $cidade ?>" name="cidade" id="cidade" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="checkout__input">
                                                            <p>Estado<span>*</span></p>
                                                            <select name="estado" id="estado" required>
                                                                <option value="AC" <?php if(@$estado == 'AC'){ ?> selected <?php } ?> >AC</option>
                                                                <option value="AL" <?php if(@$estado == 'AL'){ ?> selected <?php } ?>>AL</option>
                                                                <option value="AP" <?php if(@$estado == 'AP'){ ?> selected <?php } ?>>AP</option>
                                                                <option value="AM" <?php if(@$estado == 'AM'){ ?> selected <?php } ?>>AM</option>
                                                                <option value="BA" <?php if(@$estado == 'BA'){ ?> selected <?php } ?>>BA</option>
                                                                <option value="CE" <?php if(@$estado == 'CE'){ ?> selected <?php } ?>>CE</option>
                                                                <option value="DF" <?php if(@$estado == 'DF'){ ?> selected <?php } ?>>DF</option>
                                                                <option value="ES" <?php if(@$estado == 'ES'){ ?> selected <?php } ?>>ES</option>
                                                                <option value="GO" <?php if(@$estado == 'GO'){ ?> selected <?php } ?>>GO</option>
                                                                <option value="MA" <?php if(@$estado == 'MA'){ ?> selected <?php } ?>>MA</option>
                                                                <option value="MT" <?php if(@$estado == 'MT'){ ?> selected <?php } ?>>MT</option>
                                                                <option value="MS" <?php if(@$estado == 'MS'){ ?> selected <?php } ?>>MS</option>
                                                                <option value="MG" <?php if(@$estado == 'MG'){ ?> selected <?php } ?>>MG</option>
                                                                <option value="PA" <?php if(@$estado == 'PA'){ ?> selected <?php } ?>>PA</option>
                                                                <option value="PB" <?php if(@$estado == 'PB'){ ?> selected <?php } ?>>PB</option>
                                                                <option value="PR" <?php if(@$estado == 'PR'){ ?> selected <?php } ?>>PR</option>
                                                                <option value="PE" <?php if(@$estado == 'PE'){ ?> selected <?php } ?>>PE</option>
                                                                <option value="PI" <?php if(@$estado == 'PI'){ ?> selected <?php } ?>>PI</option>
                                                                <option value="RJ" <?php if(@$estado == 'RJ'){ ?> selected <?php } ?>>RJ</option>
                                                                <option value="RN" <?php if(@$estado == 'RN'){ ?> selected <?php } ?>>RN</option>
                                                                <option value="RS" <?php if(@$estado == 'RS'){ ?> selected <?php } ?>>RS</option>
                                                                <option value="RO" <?php if(@$estado == 'RO'){ ?> selected <?php } ?>>RO</option>
                                                                <option value="RR" <?php if(@$estado == 'RR'){ ?> selected <?php } ?>>RR</option>
                                                                <option value="SC" <?php if(@$estado == 'SC'){ ?> selected <?php } ?>>SC</option>
                                                                <option value="SP" <?php if(@$estado == 'SP'){ ?> selected <?php } ?>>SP</option>
                                                                <option value="SE" <?php if(@$estado == 'SE'){ ?> selected <?php } ?>>SE</option>
                                                                <option value="TO" <?php if(@$estado == 'TO'){ ?> selected <?php } ?>>TO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="mensagem-endereco" class="text-center col-12"></div> 
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <label class="pr-4">
                                                    <input type="checkbox" name="confirmar" id="confirmar" required> Deseja realmente alterar seus dados?
                                                </label>
                                                <input value="<?php echo @$nome_usu ?>" type="hidden" name="nome-e" id="nome-e">
                                                <input value="<?php echo @$sobrenome_usu ?>" type="hidden" name="sobrenome-e" id="sobrenome-e">
                                                <input value="<?php echo @$cpf_usu?>" type="hidden" name="cpf-e" id="cpf-e">
                                                <input value="<?php echo @$email_usu?>" type="hidden" name="email-e" id="email-e">
                                                <input value="<?php echo @$telefone_usu ?>" type="hidden" name="telefone-e" id="telefone-e">
                                                <input value="<?php echo $_SESSION['id_usuario'] ?>" type="hidden" name="txtid" id="txtid"> 
                                                <input value="<?php echo $_SESSION['cpf_usuario'] ?>" type="hidden" name="antigo" id="antigo"> 
                                                <button type="submit" name="btn-salvar-endereco" id="btn-salvar-endereco" class="btn btn-dark">Salvar</button> 
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                        <div class="editar-perfil__tab__desc">
                            <div class="container align-items-center">
                                <div class="row pt-5 ">
                                    <div class="modal-content">
                                        <div class="pb-3 pt-3 ">
                                            <h4 class="text-center" id="exampleModalLabel">Editar Email/Senha</h4>
                                        </div>
                                        <form id="form-senha" method="POST">
                                            <div class="modal-body">

                                                <div class="form-group"> <label >Email</label> <input value="<?php echo @$email_usu ?>" type="email" class="form-control" id="email-usuario" name="email-usuario" placeholder="Email"> </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">Senha</label> 
                                                            <input type="password" class="form-control d-inline-block" id="senha" name="senha" placeholder="Senha"  minlength="8" required> 
                                                            <button class="d-inline-block form-control" type="button" onClick="mostrarSenha()"><i class="fa fa-eye"></i></button> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="d-block">Confirmar Senha</label>
                                                            <input value="" type="password" class="form-control d-inline-block" id="conf-senha" name="conf-senha" placeholder="Senha"  minlength="8" required > 
                                                            <button class="d-inline-block form-control" type="button" onClick="mostrarConfSenha()"><i class="fa fa-eye"></i></button> 
                                                        </div>
                                                    </div>
                                                    <div id="mensagem-senha" class="text-center col-12"></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer"> 
                        
                                                <label class="pr-4">
                                                    <input type="checkbox" name="sameadr" required> Deseja realmente alterar seus dados?
                                                </label>
                                                <input value="<?php echo $_SESSION['id_usuario'] ?>" type="hidden" name="txtid" id="txtid"> 
                                                <input value="<?php echo $_SESSION['cpf_usuario'] ?>" type="hidden" name="antigo" id="antigo">  
                                                <button type="submit" name="btn-salvar-senha" id="btn-salvar-senha" class="btn btn-dark">Salvar</button> 
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</section>
