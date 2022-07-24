@extends('laravel-usp-theme::master')

@section('title') 
  @parent 
@endsection

@section('styles')
  @parent
  <style>
    /*seus estilos*/
  </style>
@endsection

@section('javascripts_bottom')
  @parent
  
<!-- Inclusão do jQuery-->
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js" integrity="sha256-/2tw2EWTMuKYJ22GFr6X5vPF1kkl5mb75npmfM4JUPU=" crossorigin="anonymous"></script>
<!-- Inclusão do Plugin jQuery Validation-->
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

{{--Seu código .js--}}
<script src="js/formMonografia.js"></script>
<!--script src="js/validacaoFormMonografia.js"></script-->
    
<script>
    // Seu código .js
</script>
@endsection
