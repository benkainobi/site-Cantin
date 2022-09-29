
<?php include "barre_menu.php" ?>
<div class="tg"><h1>Galerie</h1></div>
<div class="bb">
<div class="bouton mariage" id="photo m">mariage</div>
<div class="bouton grossesse" id="photo g">grossesse</div>
<div class="bouton bapteme" id="photo ba">bapteme</div>
<div class="bouton bebe" id="photo be">bebe</div>
<div class="bouton famille" id="photo f">famille</div>
<div class="bouton couple" id="photo c">couple</div>
</div>


<div class="gl">
    <img class="photo m"  src="../photos/mariage.jpeg" alt="">
    <img class="photo m"  src="../photos/mariage2.jpeg" alt="">
    <img class="photo m"  src="../photos/mariage3.jpeg" alt="">
    <img class="photo g"  src="../photos/grossesse.jpeg" alt="">
    <img class="photo g"  src="../photos/grossesse2.jpeg" alt="">
    <img class="photo g"  src="../photos/grossesse3.jpeg" alt="">
    <img class="photo be" src="../photos/bebe.jpeg" alt="">
    <img class="photo be" src="../photos/bebe2.jpeg" alt="">
    <img class="photo be" src="../photos/bebe3.jpeg" alt="">
    <img class="photo f"  src="../photos/famille.jpeg" alt="">
    <img class="photo f"  src="../photos/famille2.jpeg" alt="">
    <img class="photo f"  src="../photos/famille3.jpeg" alt="">
    <img class="photo ba" src="../photos/bapteme.jpeg" alt="">
    <img class="photo ba" src="../photos/bapteme2.jpeg" alt="">
    <img class="photo ba" src="../photos/bapteme3.jpeg" alt="">
    <img class="photo c"  src="../photos/couple.jpeg" alt="">
    <img class="photo c"  src="../photos/couple2.jpeg" alt="">
    <img class="photo c"  src="../photos/couple3.jpeg" alt="1">
</div>

<script>
    function affiche(){
let a=document.querySelectorAll('.photo');
for(u of a){if (u.className===this.id){u.style.display='block';}else{u.style.display='none';}}
    }

let boutons=document.querySelectorAll('.bouton');
for(bouton of boutons){bouton.addEventListener('mouseover',affiche);}
</script>

</body>
</html>