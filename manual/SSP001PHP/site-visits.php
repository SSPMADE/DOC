<?php 
include("db-connect.php");
?>
<div class="col-12">
    <div class="card rounded-0">
        <div class="card-body">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <colgroup>
                            <col width="15%">
                            <col width="15%">
                            <col width="20%">
                            <col width="20%">
                            <col width="30%">
                        </colgroup>
                        <thead>
                            <tr class="bg-dark text-light">
                                <th class="text-center">Date/Time</th>
                                <th class="text-center">IP</th>
                                <th class="text-center">URL</th>
                                <th class="text-center">Referer</th>
                                <th class="text-center">User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $visits = $conn->query("SELECT * FROM `visit_logs` order by abs(unix_timestamp(`date_created`)) desc");
                                if($visits->num_rows > 0):
                            ?>
                            <?php while($row = $visits->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= date("M d, Y g:i:s A", strtotime($row['date_created'])) ?></td>
                                        <td><?= $row['user_ip'] ?></td>
                                        <td><?= $row['page_url'] ?></td>
                                        <td><?= $row['reference_url'] ?></td>
                                        <td><?= $row['user_agent'] ?></td>
                                    </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <th class="text-center" colspan="5">No Data</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$conn->close();
?>