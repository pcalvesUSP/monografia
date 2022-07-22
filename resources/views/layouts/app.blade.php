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
  <!--script src="http://code.jquery.com/jquery-1.11.1.js"></script-->
  <!--script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js" integrity="sha256-0vBSIAi/8FxkNOSKyPEfdGQzFDak1dlqFKBYqBp1yC4=" crossorigin="anonymous"></script-->
  <!--script src="https://code.jquery.com/jquery-1.11.3.js" integrity="sha256-IGWuzKD7mwVnNY01LtXxq3L84Tm/RJtNCYBfXZw3Je0=" crossorigin="anonymous"></script-->
  <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js" integrity="sha256-/2tw2EWTMuKYJ22GFr6X5vPF1kkl5mb75npmfM4JUPU=" crossorigin="anonymous"></script>
  <!-- Inclusão do Plugin jQuery Validation-->
  <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
  <script src="js/formMonografia.js"></script>
  
<script>
    // Seu código .js
  </script>
@endsection
