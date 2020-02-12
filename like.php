<?php if ( isset($_SESSION['login']) ) {
                    $idmoi = $resultat2[0]['id'];
                    $intidmoi = intval($idmoi);
                    $requetecount = "SELECT COUNT(*) FROM votes WHERE id_utilisateur=$intidmoi  AND id_message=$intidcom AND valeur=1";
                    $query3 = mysqli_query($cnx, $requetecount);
                    $resultat3 = mysqli_fetch_all($query3, MYSQLI_ASSOC);
                    $requetecountdislike = "SELECT COUNT(*) FROM votes WHERE id_utilisateur=$intidmoi  AND id_message=$intidcom AND valeur=-1";
                    $query4 = mysqli_query($cnx, $requetecountdislike);
                    $resultat4 = mysqli_fetch_all($query4, MYSQLI_ASSOC);
                }
                $requetecountlikeall = "SELECT COUNT(*) FROM votes WHERE id_message=$intidcom AND valeur=1";
                $query5 = mysqli_query($cnx, $requetecountlikeall);
                $resultat5 = mysqli_fetch_all($query5, MYSQLI_ASSOC);
                $requetecountdislikeall = "SELECT COUNT(*) FROM votes WHERE id_message=$intidcom AND valeur=-1";
                $query6 = mysqli_query($cnx, $requetecountdislikeall);
                $resultat6 = mysqli_fetch_all($query6, MYSQLI_ASSOC);
                if ( isset($_SESSION['login']) && isset($_POST['likebutton'.$a]) && $resultat3[0]['COUNT(*)'] == "0" ) {
                    if ( $resultat4[0]['COUNT(*)'] == "1" ) {
                        $requeteresetlike = "DELETE FROM votes WHERE id_message=$intidcom AND id_utilisateur=$intidmoi";
                        $queryresetlike = mysqli_query($cnx, $requeteresetlike);
                    }
                    $requetelike = "INSERT INTO votes (id_utilisateur, id_message, valeur) VALUES ($intidmoi, $intidcom, 1)";
                    $querylike = mysqli_query($cnx, $requetelike);
                    header("Location: messages.php?idthread=$intidthread");
                }
                if ( isset($_SESSION['login']) && isset($_POST['likebutton'.$a]) && $resultat3[0]['COUNT(*)'] != "0" ) {
                    $requeteresetlike = "DELETE FROM votes WHERE id_message=$intidcom AND id_utilisateur=$intidmoi";
                    $queryresetlike = mysqli_query($cnx, $requeteresetlike);
                    header("Location: messages.php?idthread=$intidthread");
                }
                if ( isset($_SESSION['login']) && isset($_POST['dislikebutton'.$a]) && $resultat4[0]['COUNT(*)'] == "0" ) {
                    if ( $resultat3[0]['COUNT(*)'] == "1" ) {
                        $requeteresetdislike = "DELETE FROM votes WHERE id_message=$intidcom AND id_utilisateur=$intidmoi";
                        $queryresetdislike = mysqli_query($cnx, $requeteresetdislike);
                    }
                    $requetedislike = "INSERT INTO votes (id_utilisateur, id_message, valeur) VALUES ($intidmoi, $intidcom, -1)";
                    $querydislike = mysqli_query($cnx, $requetedislike);
                    header("Location: messages.php?idthread=$intidthread");
                }
                if ( isset($_SESSION['login']) && isset($_POST['dislikebutton'.$a]) && $resultat4[0]['COUNT(*)'] != "0" ) {
                    $requeteresetlike = "DELETE FROM votes WHERE id_message=$intidcom AND id_utilisateur=$intidmoi";
                    $queryresetlike = mysqli_query($cnx, $requeteresetlike);
                    header("Location: messages.php?idthread=$intidthread");
                }
?>