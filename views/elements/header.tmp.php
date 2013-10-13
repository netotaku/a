<html>
<head>
  <link rel="stylesheet" href="/bower_components/skeleton/stylesheets/skeleton.css">
  <link rel="stylesheet" href="/assets/css/style.css">
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