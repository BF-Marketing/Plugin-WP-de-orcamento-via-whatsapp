<html>
	<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
	</head>
	<body>

<?php

/**
 * Plugin Name: FO by Whatsapp
 * Plugin URI: 
 * Description: Este plugin possibilita a geracao de um formulario para orcamento via whatsapp.
 * Version: 1.0
 * Author: BF Marketing
 * Author URI: https://www.bfmarketing.net
 * */

 

 //Add menu to dashboard
 add_action("admin_menu","addMenu");

 function addMenu(){
     add_menu_page("FO by Whatsapp", "FO by Whatsapp", 4, "fo-whatsapp", "foMenu"); // FO means 'Formulario de orçamento' por whatsapp
     add_submenu_page("fo-whatsapp", "Adicionar Whatsapp","Adicionar Whatsapp",4,"add-whats","opcao1");
    }



//Formulario para adicionar o numero do whatsapp
    function opcao1(){
        ?>

        <div class="container">
        <br />
        <br />
        <h2 align="center">Adicionar número do Whatsapp</h2><br />
        <div class="form-group">
            <form id="add_name" method="POST">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field">
                        <tr>
                            <td><input type="number" name="numero" placeholder="Nº whatsapp com o DDD (244)" class="form-control name_list" required /></td>
                            <td><button value="add_whats" type="submit" name="add_whats" id="add_whats" class="btn btn-success">Guardar</button></td>
                        </tr>

                        <p >Nota: O contacto para o whatsapp só poderá ser inserido uma vez, caso tenha dúvida
                            se o contacto foi ou não inserido na base de dados, consulte por favor o seu banco de dados.
                        <br>
                        OBS:Preste bastante atenção ao inserir o número do whatsapp pois esta acção é irreversível.*
                        </p>
                      <p style="color: red;">Exemplo: O contacto deve ser inserido obedecendo o seguinte  padrão, **244920xx121** </p>
                    </table>
                </div>
            </form>
        </div>
    </div>



    


    <?php  // Read data from database  
    
    global $wpdb;

    $wp_table= $wpdb->prefix.'contacto_w'; // Nome da tabela com seu prefixo

    $resultado = $wpdb->get_results("SELECT * FROM $wp_table ORDER BY ID ASC");

?>

    <table class="table table-bordered table-striped ">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nº do whatsapp registrado</th>
      <th scope="col">Opções</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $value): ?>
    <tr>
      <th scope="row"><?php echo $value->id; ?> </th>
      <td><?php echo $value->numero; ?>  </td>

      <td>
          <form method="POST">
            <input type="hidden" name="id" value="<?php echo $value->id; ?>">
            <input value="Excluir" type="submit" name="remove1" id="remove1" class="btn btn-danger"/>
          </form>
      </td>

<!--  <td><a style="text-align: center;" class="btn btn-danger" href="">Excluir</a></td> -->
     
      <?php  
             
      ?>
    </tr>
    <?php break ?>
    <?php endforeach ?>


  </tbody>
</table>
    <?php   
    }

 
//Funcionalidades do menu
 function foMenu(){
    ?>

    <div class="container">
    <br />
    <br />
    <h2 align="center">Adicionar serviços ou produtos</h2><br />
    <div class="form-group">
        <form id="add_name" method="POST">
            <div class="table-responsive">
                <table class="table table-bordered" id="dynamic_field">
                    <tr>
                        <td><input type="text" name="name" placeholder="Enter service or product" class="form-control name_list" required /></td>
                        <td><button value="add" type="submit" name="add" id="add" class="btn btn-success">Adicionar </button></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>


<?php

global $wpdb;

$wp_table= $wpdb->prefix.'servicos'; // Nome da tabela com seu prefixo

$resultado = $wpdb->get_results("SELECT * FROM $wp_table ORDER BY ID ASC");

if(!isset($_POST)){
   
    echo "";

}else{

 //Formulario com a tabela de servicos e produtos
    ?>

    <table class="table table-bordered table-striped ">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Serviço ou Produto</th>
      <th scope="col">Opções</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $value): ?>
    <tr>
      <th scope="row"><?php echo $value->id; ?> </th>
      <td><?php echo $value->servicos; ?>  </td>

      <td>
          <form method="POST">
            <input type="hidden" name="id" value="<?php echo $value->id; ?>">
            <input value="Excluir" type="submit" name="remove" id="remove" class="btn btn-danger"/>
          </form>
      </td>

<!--  <td><a style="text-align: center;" class="btn btn-danger" href="">Excluir</a></td> -->
     
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
<?php
}
}


function orcamento_whatsapp(){ 
     ?>

 <div >

<!-- Frontend do Formulario de orcamento  que aparece para o usario  -->
 
<h1 style="text-align: center;">Pedir Orçamento</h1>

    <form action="" method="post">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" required>

    <label for="email">E-mail</label> 
    <input type="email" name="email" id="email" required>

    <label for="">O que você pretende adquirir?</label>
    <?php global $wpdb; $wp_table= $wpdb->prefix.'servicos';  $resultado = $wpdb->get_results("SELECT * FROM $wpdb_table ORDER BY ID ASC"); ?>

    <select name="servicos" id="">
    <?php foreach($resultado as $valor): ?>
        <option value="<?php echo $valor->servicos; ?> "><?php echo $valor->servicos; ?></option>
        <?php endforeach?>
    </select>

    <!-- Alteration 16.07.2021 -->
    <input formtarget="_blank" style="margin-top:5px;" type="submit" name="submit" value="Pedir orçamento"/>
    </form>
    </div>
    <?php
}


//Begin Condition FO BY WHATSAPP FORM
 if(isset($_POST['submit'])){ 
     
    //Variables
    $nome=$_POST['nome'];
    $email=$_POST['email'];
    $servico=$_POST['servicos'];

    
    //Content
    $msg= "Olá meu nome é *".$nome."* desejo um orçamento para a *".$servico."* este é meu endereço de email: *".$email."*";

    $msg_whats=str_replace('','%20',$msg); // API do whatsapp tem como requisito substituir os espaços por %20

    //BD data capture
    global $wpdb;

    $wp_table= $wpdb->prefix.'contacto_w'; // Nome da tabela com seu prefixo

    $resultado = $wpdb->get_results("SELECT * FROM $wp_table ORDER BY ID ASC");

    foreach($resultado as $valor): 
    
        $numWhats=$valor->numero;

    $api= "https://api.whatsapp.com/send?phone=$numWhats&text=$msg_whats";

    
?>

<script>
    window.location.assign("<?php echo $api; ?>");
</script>

<!--End condition   -->
<?php break; endforeach; ?>
<?php }


add_shortcode('orcamento','orcamento_whatsapp');


 ?>

</body>
</html>

<?php


//    Adicionar servicos no banco (Serviços ou produtos)

 if(!empty($_POST['add'])){

    if(!empty($_POST['name'])){

        $name = sanitize_text_field($_POST['name']); 

      //  global $wpdb;
        $wp_table= $wpdb->prefix.'servicos'; // Nome da tabela com seu prefixo

        $wpdb->insert($wp_table, array('servicos' => $name) );

    }else{
        echo "Todos campos são obrigatorios.";
    }

 }

 //    Adicionar numero no banco (Numero do whatsapp)

 if(!empty($_POST['add_whats'])){

    if(!empty($_POST['numero'])){

      //  global $wpdb;
        $wp_table= $wpdb->prefix.'contacto_w'; // Nome da tabela com seu prefixo

        $wpdb->insert($wp_table, array('numero' => $_POST['numero']));


    }else{
        echo "Todos campos são obrigatorios.";
    }

 }


 //    Remover servicos da bd

 if(!empty($_POST['remove'])){


    if(!empty($_POST['id'])){
         
        $id= $_POST['id'];
        //  global $wpdb;
        $wp_table= $wpdb->prefix.'servicos'; // Nome da tabela com seu prefixo
        
        $delete_service= $wpdb->delete($wp_table, array('id'=> $id));

    }else{
        echo "Todos campos são obrigatorios.";
    }

 }


 
 //    Remover contacto da bd

 if(!empty($_POST['remove1'])){


    if(!empty($_POST['id'])){
         
        $id= $_POST['id'];
        //  global $wpdb;
        $wp_table= $wpdb->prefix.'contacto_w'; // Nome da tabela com seu prefixo
        
        $delete_service= $wpdb->delete($wp_table, array('id'=> $id));

    }else{
        echo "Todos campos são obrigatorios.";
    }

 }


 
?>


