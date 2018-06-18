<?php
  header("Content-type: text/css");
?>

body {
  font-family: "Courier";
  margin: 0;
  padding: 0;
  background: #C6C7CC url("https://channel.piyo.cafe/img/fadeBlue.png") top repeat-x;
  color: #727EA0;
  word-wrap: break-word;
}

.top {
  margin: auto;
  padding-left: 1.0em;
  padding-right: 1.0em;
  text-align: left;
  max-width: 100vw;;
  font-size: 0.813em;
}

.largeLogo {
  margin: auto;
  display: block;
}

div {
  display: block;
}

p,h2,h3 {
  margin: 0;
}

a {color: inherit; text-decoration: underline; cursor: pointer;}
a:link {text-decoration: underline;}
a:hover {font-weight: bold;}
a:active {font-weight: bold;}
a:focus {font-weight: bold;}

hr {
  display: block;
  height: 1px;
  border: 0;
  border-top: 1px solid #727EA0;
  margin: 0;
  margin-top: 0.0em;
  margin-bottom: 1.0em;
  padding: 0;
}

.box {
  border: 1px solid;
  margin-bottom: 1em;
  overflow: hidden;
  display: inline-block;
  max-width: 80%;
}

.box-header {
  background: #727EA0;
  color: #FFFFFF;
  padding: .5em;
  padding-top: .25em;
  padding-bottom: .25em;
  max-width: 100%;
}

.box-body {
  background: #FFFFFF;
  padding: .5em;
  padding-top: .25em;
  padding-bottom: .25em;
  overflow: hidden;
  max-width: 100%;
}

.thread-expand {
  font-weight: bold;
  text-decoration: none;
}

.thread-title {
  font-weight: bold;
  font-size: 1.17em;
}

.thread-user {
  display: inline;
  font-weight: bold;
}

.thread-timestamp {
  display: inline;
  font-style: italic;
}

.thread-postID {
  display: inline;
  font-style: italic;
  text-align: right;
  text-decoration: none;
}

.thread-postID-div {
  text-align: right;
}

.thread-numReplies {
  display: inline;
  font-style: italic;
}

.thread-body {
}

.thread-title {color: #FFFFFF;}
.thread-title:link {color: #FFFFFF;}
.thread-title:visited {color: #FFFFFF;}
.thread-title:hover {color: #FFFFFF;}
.thread-title:active {color: #FFFFFF;}
.thread-title:focus {color: #FFFFFF;}

.post {
}

form {
  margin-bottom: 0.35em;
}

.label {
}

.input {
  border: 1px solid #727EA0;
  background: #FFFFFF;
  color: #727EA0;
  margin-bottom: 0;
  width: 100%;
  padding: 1px;
}

.post-error {
  color: red;
}

.replies {
  margin-left: 3.0em;
}