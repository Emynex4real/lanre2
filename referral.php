<?php 
	$page__css = '
		<link rel="stylesheet" href="css/referral.css" />
		<link rel="stylesheet" href="css/navbar.css" />
	'; 

  require_once("layout/user-header.php"); ?>

    <main>

      <div class="referral-panel">
        <p class="head">Referral</p>
      </div>
      <section class="referral">
        <div class="referral-container">
          <div class="total-referral-earned">
            <div class="total-referral">
              <i class="fas fa-users"></i>
              <div class="referral-text">
                <p class="text">TOTAL REFERRALS</p>
                <p class="amount">32</p>
              </div>
            </div>
            <div class="total-earned">
              <i class="fas fa-coins"></i>
              <div class="referral-text">
                <p class="text">TOTAL EARNED</p>
                <p class="amount">250.0</p>
              </div>
            </div>
          </div>
          <div class="referral-link">
            <div class="details">
                <p class="text">Referral Link:</p>
                <div class="link">
                  <p class="text">
                    https://app.bapemall.com/reg/jaye9 <i class="fas fa-copy"></i>
                  </p>
                </div>
                <a href=""><button class="share">SHARE</button></a>
            </div>
            <p class="texts">Get 10% for each invited user</p>
          </div>
        </div>
        <div class="my-referrals">
          <p class="text">My Referrals</p>
          <div class="referral-details">
            <table>
              <tr>
                <th>DATE</th>
                <th>USER</th>
                <th>REFERRAL</th>
                <th>PROFIT</th>
              </tr>
              <tr>
                <td style="border-radius: 10px 0 0 10px;">08.12. 21:21</td>
                <td>Michael Balogun</td>
                <td class="user"><i class="fas fa-users"></i>1</td>
                <td style="border-radius: 0 10px 10px 0; font-weight: 700;">+150</td> 
              </tr>
              <tr>
                <td style="border-radius: 10px 0 0 10px;">08.12. 21:21</td>
                <td>Shina Ayomide</td>
                <td class="user"><i class="fas fa-users"></i>9</td>
                <td style="border-radius: 0 10px 10px 0; font-weight: 700;">+350</td> 
              </tr>
              <tr>
                <td style="border-radius: 10px 0 0 10px;">08.12. 21:21</td>
                <td>Dagwan Sunday</td>
                <td class="user"><i class="fas fa-users"></i>3</td>
                <td style="border-radius: 0 10px 10px 0; font-weight: 700;">+200</td> 
              </tr>
            </table>
          </div>
        </div>
        
          
          
      </section>
    </main>

    <script src="navbar.js"></script>
  </body>
</html>
