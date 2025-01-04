<?php
    require_once("function.php");
    $search_query = $_POST["search"];

    $user_sql = "SELECT * FROM `users` WHERE CONCAT(email) LIKE :search ORDER BY ID DESC";
    $user_query = $db->prepare($user_sql);
    $user_query->execute([":search" => '%' . $search_query . '%']);
    $number_of_users = $user_query->rowCount();
    $user_details = $user_query->fetchAll(PDO::FETCH_ASSOC); 

    try {
        if ($number_of_users > 0) { 
            foreach ($user_details as $user): 
                $user_balance = get_user_balances($user["id"]);
                $deposit_balance = $user_balance ? number_format($user_balance["deposit_balance"]) : 0;
                $income_balance = $user_balance ? number_format($user_balance["income_balance"]) : 0; 
                $total_user_investments = get_total_user_investments($user["id"]) ? number_format(get_total_user_investments($user["id"])) : 0; 
                $total_user_team_investment = checkUserTeamTotalInvestment($user["referral_code"]) ? number_format(checkUserTeamTotalInvestment($user["referral_code"])) : 0; ?>

                <tr>
                    <td scope="row" style="color: #000;"><b><?= $user["email"] ?></b></td>
                    <td><b><?= "₦" . $deposit_balance ?></b></td>
                    <td><b><?= "₦" . $income_balance ?></b></td>
                    <td><b><?= "₦" . $total_user_investments ?></b></td>
                    <td><b><?= get_user_team_size($user["referral_code"]) ?></b></td>
                    <td><b><?= get_user_valid_team_size($user["id"]) ?></b></td>
                    <td><b><?= "₦" . $total_user_team_investment ?></b></td>
                    <td><b><?= ucfirst($user["rank"]) ?></b></td>

                    <td>
                        <?php if (check_if_user_has_ever_invested($user["id"])) { ?>
                            <button class="success-btn mobile-w-fit">
                                <i class="fa-solid fa-mark fa-lg"></i>
                                <span>Active</span> 
                            </button>
                        <?php } elseif ($user["verification"] == 0) { ?>
                            <button class="danger-btn mobile-w-fit">
                                <i class="fa-solid fa-xmark fa-lg"></i>
                                <span>Inactive</span> 
                            </button>
                        <?php } else { ?>
                            <button class="danger-btn mobile-w-fit">
                                <i class="fa-solid fa-xmark fa-lg"></i>
                                <span>Banned</span> 
                            </button>
                        <?php } ?>
                    </td>

                    <td style=" margin-right: 20px;">
                        <button class="editbtn1 mobile-w-100 funds-btn flex" onclick="runAddFundsButton(<?= $user['id'] ?>, '<?= $user['email'] ?>')">
                            <i class="fa-solid fa-plus fa-lg mr-1"></i>
                            <span id="span<?= $user["id"] ?>" style="min-width: 100px">Add Funds</span> 
                        </button>
                    </td>

                    <td style="padding-left: 40px;">
                        <?php if ($user["verification"] == 1 || $user["verification"] == 0) { ?>
                            <button class="editbtn1 ban mobile-w-100 action-btn flex" onclick="runBanButton(<?= $user['id'] ?>, '<?= $user['email'] ?>', 'ban')">
                                <i class="fa-solid fa-xmark fa-lg mr-1"></i>
                                <span id="span<?= $user["id"] ?>" style="min-width: 80px">Ban user</span> 
                                <i class="fa-solid fa-user fa-lg"></i>
                            </button>
                        <?php } else { ?>
                            <button class="editbtn1 unban mobile-w-100 action-btn flex" data-user="<?= $user["id"] ?>" onclick="runBanButton(<?= $user['id'] ?>, '<?= $user['email'] ?>', 'unban')">
                                <i class="fa-solid fa-circle-check fa-lg mr-1"></i>
                                <span id="span<?= $user["id"] ?>" style="min-width: 100px">Unban user</span> 
                                <i class="fa-solid fa-user fa-lg"></i>
                            </button>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach;
        } else { ?>
            <tr>
                <td scope="row" colspan="4" style="color: #000;">There is no result for <b><?= ucfirst($search_query) ?></b></td>
            </tr>
        <?php }
    } catch(PDOException $e) { echo $e; }
?>
