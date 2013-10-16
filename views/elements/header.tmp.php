<html>
<head>
  <link type='text/css' rel="stylesheet" href="/bower_components/skeleton/stylesheets/skeleton.css">
  <link type='text/css' rel='stylesheet' href='http://fonts.googleapis.com/css?family=EB+Garamond'>
  <link type='text/css' rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <header>
    <h1>Anagram</h1>
    <?php if($g->in_progress()) : ?>
      <nav>
        <ul>
          <li><a href="/quit">Restart</a></li>
        </ul>
      <nav>
    <?php endif; ?>
  </header>