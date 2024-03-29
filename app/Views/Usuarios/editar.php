<?php $this->extend('Layout/principal');?>

<?php $this->section('titulo');?>
<?php /** @var TYPE_NAME $titulo */
echo $titulo;?>
<?php $this->endsection();?>

<?php $this->section('estilos');?>

<?php $this->endsection();?>


<?php $this->section('conteudo');?>

    <div class="row">
        <div class="col-lg-6">
            <div class="block">
                <div class="block-body">
                    <div id="response">

                    </div>
                    <?php /** @var TYPE_NAME $usuario */ echo form_open('/', ['id' => 'form'], ['id' => "$usuario->id"]);?>

                    <?php echo $this->include('Usuarios/_form');?>

                    <div class="form-group mt-5 mb-2">

                        <input id="btn-salvar" type="submit" value="Salvar" class="btn btn-danger btn-sm mr-2">
                        <a href="<?php echo site_url("usuarios/exibir/$usuario->id");?>" class="btn btn-secondary btn-sm ml-2">Voltar</a>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div> 
        </div>
    </div>
<?php $this->endsection();?>

<?php $this->section('scripts');?>

    <script>
        $(document).ready(function() {

            $("#form").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('usuarios/atualizar'); ?>',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    
                    beforeSend: function(){
                        $("#response").html(this.data);
                        $("#btn-salvar").val('Por favor Aguarde...');
                    },

                    success: function(response){
                        $("#btn-salvar").val('Salvar');
                        $("#btn-salvar").removeAttr('disabled');
                        $('[name=csrf_sistema]').val(response.token);

                        if (!response.erro) {

                            if (response.info) {

                                $("#response").html('<div class="alert alert-info">'+ response.info +'</div>');

                            } else {
                                //Tudo ok com a atualização do usuário
                                // Será feito o redirecionamento do usuário
                                window.location.href = "<?php echo site_url("usuarios/exibir/$usuario->id");?>";
                            }
                        }

                        if(response.erro){
                            // Existem erros de validação
                            $("#response").html('<div class="alert alert-danger">'+ response.erro +'</div>');

                            if(response.erros_model) {
                                $.each(response.erros_model, function(key, value) {
                                    $("#response").append('<ul class="list-unstyled"><li class="text-danger">'+ value +'</li></ul>');

                                });
                            }
                        }
                    },
                    error: function() {
                        alert('Não foi possível processar a solicitação, por favor entre em contato com o suporte');
                        $("#btn-salvar").val('Salvar');
                        $("#btn-salvar").removeAttr('disabled');
                    }


                });
            });

            $("#form").submit(function(){
                $(this).find(":submit").attr('disabled', 'disabled');
            });
        });
    </script>

<?php $this->endsection();?>