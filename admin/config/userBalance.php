<?php   
    class UserBalance {
        public $user_balance;
        public $app_user_id;

        public function __construct($user_id,) {
            global $db;

            try {
                $stmt = $db->prepare("SELECT * FROM `user_balance` WHERE user_id = :id");
                $stmt->execute([':id'  =>  $user_id]);
                $this->app_user_id = $user_id;
                $this->user_balance = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) { echo $e; }
        }


        public function addDepositBalance($amount) {
            global $db;

            try {
                $deposit_balance = ((float) $this->user_balance["deposit_balance"] + (float) $amount);
                $total_deposit = ((float) $this->user_balance["total_deposit"] + (float) $amount);

                $stmt = $db->prepare("UPDATE `user_balance` SET `deposit_balance` = :amount, `total_deposit` = :T_deposit WHERE `user_id` = :id");
                $stmt->execute([
                    ':id' => $this->app_user_id,
                    ':amount' => $deposit_balance,
                    ':T_deposit' => $total_deposit
                ]);

                 // Check if user is referred, if it is first Deposit,
                // then pay Referrals up to level 5
                $firstDeposit = get_user_info_by_id($this->app_user_id)["first_deposit"];

                if ($firstDeposit == 0) {
                    require_once("../../config/referrralHandler.php");
                    handleReferralsBonuses($this->app_user_id, (float) $amount);
                }


            } catch (PDOException $e) { echo $e; }
        }

        public function updateTransaction($deposit_id) {
            global $db;
            $sql = "UPDATE `transactions` SET `status` = :status WHERE `id` = :deposit_id";
            $query = $db->prepare($sql);
            $query->execute(array (
                ':deposit_id'      =>   $deposit_id,
                ':status'          =>   2,
            ));
        }


        public function newTransaction($description, $amount, $status, $type) {
            global $db; 
            $transaction_id = substr(md5(rand()),0,5);
			$transaction_code = str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT);
            $transaction_id .= $transaction_code;

            try {
                $stmt = $db->prepare("INSERT INTO `transactions` (user_id, description, amount, status, transaction_id, transaction_type) VALUES (:id, :type, :amount, :status, :transaction_id, :trans_type)");
                $stmt->execute([
                    ':id'             =>  $this->app_user_id,
                    ':trans_type'     =>  $type,
                    ':type'           =>  $description,
                    ':amount'         =>  $amount,
                    ':status'         =>  $status,
                    ':transaction_id' =>  $transaction_id
                ]);
            } catch (PDOException $e) { echo $e; }
        }
    }

?>