<?php
  include './lib/all.php';

  if (requiresAuth()) {
    $accountID = $_GET['id'];
    $transactions = Transaction::getTransaction($accountID);
  }
 ?>

 <?php writeHeader(); ?>
 <div class="container-fluid">
   <div class="row mt-4">
     <div class="col px-5">
       <h1>Welcome to Cashless Bank!</h1>
     </div>
   </div>

   <div class="row mt-2">
     <div class="col-8 px-5">
       <table class="table">
         <tr>
           <th>From ID</th>
           <th>To ID</th>
           <th>Amount</th>
           <th>Account Type</th>
           <th>Timestamp</th>
         </tr>

         <?php foreach ($transactions as &$transaction): ?>
         <tr>
             <td><?php echo $transaction->fromAccountID; ?></td>
             <td><?php echo $transaction->toAccountID; ?></td>
             <td><?php echo $transaction->amount; ?></td>
             <td><?php echo $transaction->type; ?></td>
             <td><?php echo $transaction->timestamp; ?></td>
           </a>
         </tr>
       <?php endforeach; ?>
       </table>
     </div>

     <?php $quote = getRandomQuote(); ?>

     <div class="col px-5">
       <div class="card">
         <div class="card-body">
           <blockquote class="blockquote mb-0">
             <p>"<?php echo $quote['quote']; ?>"</p>
             <footer class="blockquote-footer">Cashless Bank CEO, Tom Dickerson (<?php echo $quote['subquote']; ?>)</footer>
           </blockquote>
         </div>
       </div>
     </div>
   </div>
 </div>
 <?php writeFooter(); ?>
