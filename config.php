<?php

  $key = 'a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5';
  $url = 'http://api.wordnik.com/v4/';
  $wrdURL = $url."words.json/randomWord?";
  $defURL = $url."word.json/";

  $wrdQS = array(
      "hasDictionaryDef" => "true",
      "minCorpusCount" => "1000",
      "maxCorpusCount" => "-1",
      "minDictionaryCount" => "1",
      "maxDictionaryCount" => "-1",
      "minLength" => "5",
      "maxLength" => "-1",
      "api_key" => $key
      );

  $defQS = array(
      "limit" => "200",
      "includeRelated" => "true",
      "useCanonical" => "false",
      "includeTags" => "false",
      "api_key" => $key
      );