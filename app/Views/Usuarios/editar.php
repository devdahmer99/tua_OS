<?php $this->extend('Layout/principal');?>

<?php $this->section('titulo');?>
    <?php echo $titulo;?>
<?php $this->endsection();?>

<?php $this->section('estilos');?>

<?php $this->endsection();?>


<?php $this->section('conteudo');?>

    <div class="row">
        <div class="col-lg-6">
            <div class="block">
                <div class="block-body">
                    <div id="response">
                    <?php echo form_open('/', ['id' => 'form'], ['id' => "$usuario->id"]);?>

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
    </div>
<?php $this->endsection();?>

<?php $this->section('scripts');?>

    <script>
        $(document).ready(function() {
            $("#form").on('submit', function(e){
                e.preventDefault();

                var dados = $("#form").serialize();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('usuarios/atualizar'); ?>',
                    data: dados,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $("#btn-salvar").val('Por favor Aguarde...');
                        //$("#response").html('');
                    },
                    success: function(){
                        $("#btn-salvar").val('Salvar');
                        $("#btn-salvar").removeAttr('disabled');
                    }
                });
            });
        });
    </script>

<?php $this->endsection();?>