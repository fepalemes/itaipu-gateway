<?php

    add_action('init','acesso_post_action');
    function acesso_post_action(){
    if( isset($_GET['access_action']) AND $_SERVER['REQUEST_METHOD'] == 'POST' )
        include(__DIR__.'/form.php');
    }

    add_shortcode('acesso_form', 'acesso_form');
    function acesso_form(){

    if ($_COOKIE["ItaipuEnter"] === '1'){
    echo '<script>window.location.href = "'. get_home_url() .'?p='.$_GET[redirect_to].'";</script>'; 
    }
?>

<p>
<?php
    echo $_GET['msg'];
?>
</p>

<form class="login-form" method="post" action="?access_action">
    <input type="email" placeholder="E-mail de acesso" name="email" id="email" />
    <input type="hidden" name="redirect_to" value="<?php echo $_GET[redirect_to]; ?>" />
    <button>login</button>
</form>

<script type="text/javascript">
    if(typeof wpOnload=='function')wpOnload();
</script>

<?php }

    add_action('wp_loaded', 'ck_access_logged');
    function ck_access_logged(){
    if ( is_user_logged_in() )
        return ;

    $request_uri = strtolower($_SERVER['REQUEST_URI']) ;
    if ($_COOKIE["ItaipuEnter"] !=='1' AND !strstr($request_uri,'acesso') ){
        header('Location: '
            . get_home_url( NULL,
                '/acesso/?redirect_to=' .
                base64_encode( 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] )
            )
        );
        exit;
    }
    }

