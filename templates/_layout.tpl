{extends file="_layoutBase.tpl"}
{if !isset($user) || $user->style eq "light"}
{assign var="navbar_color" value="navbar-light bg-faded" nocache}
{assign var="body_class" value="" nocache}
{block name="css" append}
<link type="text/css" rel="stylesheet" href="/styles_c/colorLight.css" />
<link type="text/css" rel="stylesheet" href="/styles_c/highlightjs/vs.css" />
{/block}
{else}
{assign var="navbar_color" value="navbar-inverse bg-inverse" nocache}
{assign var="body_class" value="text-white bg-inverse" nocache}
{block name="css" append}
<link type="text/css" rel="stylesheet" href="/styles_c/colorDark.css" />
<link type="text/css" rel="stylesheet" href="/styles_c/highlightjs/androidstudio.css" />
{/block}

{/if}
{block name="js_end" append}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js" crossorigin="anonymous"></script>

<script>
  window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<script src="/js_c/bootstrap.js"></script>
{/block}