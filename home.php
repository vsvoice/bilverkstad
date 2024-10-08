<?php
include_once 'includes/functions.php';    
include_once 'includes/header.php';

$user->checkLoginStatus();
$test = $user->checkUserRole(10);

// Use the global PDO instance from the config file
global $pdo; // Access the global PDO instance

// Initialize an array to hold projects by status
$projects_by_status = [];

// Fetch projects from the database with joins
$sql = "
    SELECT p.*, 
           c.customer_fname, 
           c.customer_lname, 
           ca.car_brand, 
           ca.car_model 
    FROM table_projects p
    LEFT JOIN table_cars ca ON p.car_id_fk = ca.car_id
    LEFT JOIN table_customers c ON p.customer_id_fk = c.customer_id
    ORDER BY p.status_id_fk
";
$stmt = $pdo->prepare($sql); // Use the $pdo object
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $status_id = $row['status_id_fk'];
    $projects_by_status[$status_id][] = $row; // Group projects by their status
}
?>

<div class="container text-center">
    <div class="row my-3">
        <h2>Pågående</h2>
        <div class="col">
            <?php if (isset($projects_by_status[1])): ?>
                <div class="row d-flex justify-content-center">
                    <?php foreach ($projects_by_status[1] as $project): ?>
                        <div class="col-md-6 mb-4"> <!-- Changed from col-md-4 to col-md-6 for more width -->
                            <div class="card" style="border: none; min-height: 100px;"> <!-- Optionally set a minimum height -->
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="project.php?project_id=<?php echo htmlspecialchars($project['project_id']); ?>" style="text-decoration: none; color: inherit;">
                                            <?php echo htmlspecialchars($project['work_desc']); ?>
                                        </a>
                                    </h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text mb-0"><strong>Car:</strong> <?php echo htmlspecialchars($project['car_brand']) . ' ' . htmlspecialchars($project['car_model']); ?></p>
                                        <p class="card-text mb-0"><strong>Customer:</strong> <?php echo htmlspecialchars($project['customer_fname']) . ' ' . htmlspecialchars($project['customer_lname']); ?></p>
                                        <p class="card-text mb-0"><strong>Defect Description:</strong> <?php echo htmlspecialchars($project['defect_desc']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Inga projekt i Pågående.</p>
            <?php endif; ?>
        </div>  
    </div>

    <!-- Repeat similar structure for other project statuses (I kö, Klar för Fakturering, Fakturerad) -->

    <div class="row my-3">
        <h2>I kö</h2>
        <div class="col">
            <?php if (isset($projects_by_status[2])): ?>
                <div class="row d-flex justify-content-center">
                    <?php foreach ($projects_by_status[2] as $project): ?>
                        <div class="col-md-6 mb-4"> <!-- Changed from col-md-4 to col-md-6 for more width -->
                            <div class="card" style="border: none; min-height: 100px;"> <!-- Optionally set a minimum height -->
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="project.php?project_id=<?php echo htmlspecialchars($project['project_id']); ?>" style="text-decoration: none; color: inherit;">
                                            <?php echo htmlspecialchars($project['work_desc']); ?>
                                        </a>
                                    </h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text mb-0"><strong>Car:</strong> <?php echo htmlspecialchars($project['car_id_fk']); ?></p>
                                        <p class="card-text mb-0"><strong>Customer:</strong> <?php echo htmlspecialchars($project['customer_id_fk']); ?></p>
                                        <p class="card-text mb-0"><strong>Defect Description:</strong> <?php echo htmlspecialchars($project['defect_desc']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Inga projekt i kö.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row my-3">
        <h2>Klar för Fakturering</h2>
        <div class="col">
            <?php if (isset($projects_by_status[3])): ?>
                <div class="row d-flex justify-content-center">
                    <?php foreach ($projects_by_status[3] as $project): ?>
                        <div class="col-md-6 mb-4"> <!-- Changed from col-md-4 to col-md-6 for more width -->
                            <div class="card" style="border: none; min-height: 100px;"> <!-- Optionally set a minimum height -->
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="project.php?project_id=<?php echo htmlspecialchars($project['project_id']); ?>" style="text-decoration: none; color: inherit;">
                                            <?php echo htmlspecialchars($project['work_desc']); ?>
                                        </a>
                                    </h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text mb-0"><strong>Car:</strong> <?php echo htmlspecialchars($project['car_id_fk']); ?></p>
                                        <p class="card-text mb-0"><strong>Customer:</strong> <?php echo htmlspecialchars($project['customer_id_fk']); ?></p>
                                        <p class="card-text mb-0"><strong>Defect Description:</strong> <?php echo htmlspecialchars($project['defect_desc']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Inga projekt klara för fakturering.</p>
            <?php endif; ?>
        </div>  
    </div>

    <div class="row my-3">
        <h2>Fakturerad</h2>
        <div class="col">
            <?php if (isset($projects_by_status[4])): ?>
                <div class="row d-flex justify-content-center">
                    <?php foreach ($projects_by_status[4] as $project): ?>
                        <div class="col-md-6 mb-4"> <!-- Changed from col-md-4 to col-md-6 for more width -->
                            <div class="card" style="border: none; min-height: 100px;"> <!-- Optionally set a minimum height -->
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="project.php?project_id=<?php echo htmlspecialchars($project['project_id']); ?>" style="text-decoration: none; color: inherit;">
                                            <?php echo htmlspecialchars($project['work_desc']); ?>
                                        </a>
                                    </h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text mb-0"><strong>Car:</strong> <?php echo htmlspecialchars($project['car_id_fk']); ?></p>
                                        <p class="card-text mb-0"><strong>Customer:</strong> <?php echo htmlspecialchars($project['customer_id_fk']); ?></p>
                                        <p class="card-text mb-0"><strong>Defect Description:</strong> <?php echo htmlspecialchars($project['defect_desc']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Inga fakturerade projekt.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>
