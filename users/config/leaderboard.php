<?php
    // leaderboard.php
    include_once 'conn.php'; // Include your database connection file

    class ReferralLeaderboard {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getLeaderboard() {
            try {
                // Query to get the leaderboard with user details, limited to the top 25 earners
                $stmt = $this->db->prepare("
                    SELECT u.user_id, u.username, u.email, SUM(r.amount_earned) AS total_earned
                    FROM referrals r
                    INNER JOIN users u ON r.referred_by = u.user_id
                    GROUP BY r.referred_by
                    ORDER BY total_earned DESC
                    LIMIT 25
                ");
                $stmt->execute();
                $leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $leaderboard;
            } catch (PDOException $e) {
                // Handle any errors
                echo "Error: " . $e->getMessage();
                return [];
            }
        }
    }


    $leaderboard = new ReferralLeaderboard($db);
    $datas = $leaderboard->getLeaderboard();
    $leadersData = "";

    foreach($datas as $index => $leader) {
        if ($index == 0) {
             $winner = ' <img class="gold-medal" src="https://github.com/malunaridev/Challenges-iCodeThis/blob/master/4-leaderboard/assets/gold-medal.png?raw=true" alt="gold medal"/>';
        } else { $winner = ""; };

        $leadersData .= '
            <tr>
                <td class="number">' . ($index + 1) . '</td>
                <td class="name">' .  $leader["username"]. '</td>
                <td class="points">
                    ₦' .  number_format($leader["total_earned"]) .   $winner. '
                </td>
            </tr>
        ';
    }
    print($leadersData);
?>
