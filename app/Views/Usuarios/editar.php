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
                            
                    </div>

                    <?php echo form_open('/', ['id' => 'form'], ['id' => "$usuario->id"]);?>
                        <div class="form-group mt-5 mb-2">
                            <input type="submit" id="btn-salvar" class="btn btn-danger mr-2">
                            <a href="<?php echo site_url("usuarios/exibir/$usuario->id");?>" class="btn btn-secondary ml-2">Voltar</a>
                        </div>
                    <?php echo form_close();?>
                </div>
            </div> 
        </div>
    </div>


<?php $this->endsection();?>


<?php $this->section('scripts');?>

<?php $this->endsection();?>