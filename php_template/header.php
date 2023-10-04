<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
</head>
<header-group>
    <header>
        <left>
            <content>
                <input type="image" id="burger-button" class="burger-menu" src="https://cdn-icons-png.flaticon.com/512/482/482609.png">
            </content>
        </left>
        <middle>
            <content>
                <a href="http://localhost/HACKATHON/php_template/home.php">
                    <img src="https://cdn-icons-png.flaticon.com/512/4685/4685215.png">
                </a>
            </content>
        </middle>
        <right>
            <content>
                <?php if (isset($_SESSION["username"])) {
                if (!empty($_SESSION["avatar"])|| isset($_SESSION["avatar"])) {
             $image = "../Avatars/".$_SESSION["avatar"];
                } else {
                $image = "../Avatars/default.png";
                }
             echo "<user>
             <a href=\"../function/logout.php\">
             <img src=\"https://cdn-icons-png.flaticon.com/512/992/992680.png\">
             </a>
             <a href=\"../php_template/editingProfile.php\">
             <img src=\"$image\">
             </a>
             </user>";
                } else {
                    echo "
                <a href=\"http://localhost/HACKATHON/php_template/RegisterHtml.php\">
                <input type=\"button\" value=\"Sign up\">
                </a>
                <a href=\"http://localhost/HACKATHON/php_template/loginHtml.php\">
                <input type=\"button\" value=\"Login\">
                </a>";
                } ?>
            </content>
        </right>
    </header>
    <burger-menu id="burger-menu">
        <a href="http://localhost/HACKATHON/php_template/home.php">
            <div id="burger-link">
                <p>Home</p>
            </div>
        </a>
    </burger-menu>
</header-group>
<script>
    const button = document.getElementById("burger-button");
    let isClicked = false;
    button.addEventListener("click", showForm);

    function showForm() {
        if (!isClicked) {
            isClicked = true;
            document.getElementById("burger-menu").style.display = "block";
        } else {
            isClicked = false;
            document.getElementById("burger-menu").style.display = "none";
        }
    }
</script>