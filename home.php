<?php
include_once 'includes/functions.php';    
include_once 'includes/header.php';

$user->checkLoginStatus();
$isMechanic = $user->checkUserRole(10);
$isAccountant = $user->checkUserRole(50);
$isBoss = $user->checkUserRole(200);
$isAdmin = $user->checkUserRole(500);

// Use the global PDO instance from the config file
global $pdo; 

// Initialize an array to hold projects by status
$projects_by_status = [];

// Determine which statuses to fetch based on user role
$status_condition = [];
if ($isBoss || $isAdmin) {
    // Boss and Admin see all projects
    $status_condition = [1, 2, 3, 4, 5, 6, 7];
} elseif ($isAccountant) {
    // Accountants see projects with status 3 and 4
    $status_condition = [3, 4, 5];
} elseif ($isMechanic) {
    // Mechanics see projects with status 1 and 2
    $status_condition = [1, 2, 3];
}

// Fetch projects from the database with joins based on the status condition
if (!empty($status_condition)) {
    $status_placeholders = implode(',', array_fill(0, count($status_condition), '?'));
    $sql = "
        SELECT p.*, 
               c.customer_fname, 
               c.customer_lname, 
               ca.car_brand, 
               ca.car_model 
        FROM table_projects p
        LEFT JOIN table_cars ca ON p.car_id_fk = ca.car_id
        LEFT JOIN table_customers c ON p.customer_id_fk = c.customer_id
        WHERE p.status_id_fk IN ($status_placeholders)
        ORDER BY p.status_id_fk
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($status_condition);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $status_id = $row['status_id_fk'];
        $projects_by_status[$status_id][] = $row; // Group projects by their status
    }
}
?>

<div class="container text-center">
    <div class="mw-500 mx-auto">
        <!-- Array of project statuses -->
        <?php
        $statuses = [
            1 => "I Kö",
            2 => "Pågående",
            3 => "Pausad",
            4 => "Klar för Fakturering",
            5 => "Fakturerad",
            6 => "Betalad",
            7 => "Avbokad"
        ];

        foreach ($statuses as $status_id => $status_title): ?>
            <?php if (isset($projects_by_status[$status_id])): // Check if the user has projects in this status ?>
                <div class="row my-3">
                    <h2><?php echo $status_title; ?></h2>
                    <div class="col">
                        <div class="row d-flex justify-content-center">
                            <?php foreach ($projects_by_status[$status_id] as $project): ?>
                                <div class="col mb-4">
                                    <div class="card" style="border: none; min-height: 100px;">
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
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>
