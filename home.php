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
    $status_condition = [1, 2, 3, 5, 6];
} elseif ($isAccountant) {
    // Accountants see projects with status 3, 4 and 5
    $status_condition = [5, 6];
} elseif ($isMechanic) {
    // Mechanics see projects with status 1, 2 and 3
    $status_condition = [1, 2, 5];
}

// Fetch projects from the database with joins based on the status condition
if (!empty($status_condition)) {
    $status_placeholders = implode(',', array_fill(0, count($status_condition), '?'));
    $sql = "
       SELECT 
        p.*, 
        c.customer_fname, 
        c.customer_lname, 
        ca.car_brand, 
        ca.car_model, 
        ca.car_license, 
        p.creation_date,
        MAX(h.h_date) AS most_recent_date  -- Getting the most recent date for each project
    FROM table_projects p
    LEFT JOIN table_cars ca ON p.car_id_fk = ca.car_id
    LEFT JOIN table_customers c ON p.customer_id_fk = c.customer_id
    LEFT JOIN table_hours h ON p.project_id = h.p_id_fk
    WHERE p.status_id_fk IN ($status_placeholders)
    GROUP BY p.project_id, c.customer_fname, c.customer_lname, ca.car_brand, ca.car_model, ca.car_license, p.creation_date
    ORDER BY p.status_id_fk
    ";
    // Include car_license in the SELECT statement, Make sure to select the creation_date

    $stmt = $pdo->prepare($sql);
    $stmt->execute($status_condition);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $status_id = $row['status_id_fk'];
        $projects_by_status[$status_id][] = $row; // Group projects by their status
    }
}
?>

<div class="container text-center">
    <div class="mx-auto">
    <p class="mt-5 mb-3 fst-italic">Tryck på något projekt för att öppna det.</p>
        <!-- Array of project statuses -->
        <?php   
        $statuses = [
            2 => "Pågående",
            1 => "I kö",
            3 => "Pausat",
            4 => "Avbokat",
            5 => "Klart för fakturering",
            6 => "Fakturerat",
            7 => "Betalt"
        ];

        foreach ($statuses as $status_id => $status_title): ?>
            <?php if (isset($projects_by_status[$status_id])): // Check if the user has projects in this status ?>
                <div class="row my-3">
                    <h2 class="mb-4"><?php echo $status_title; ?></h1>
                    <div class="col">
                        <div class="row d-flex justify-content-center">

                            <?php foreach ($projects_by_status[$status_id] as $project): ?>
                                <?php
                                    // Calculate the number of days since the project creation date
                                    $creationDate = new DateTime($project['creation_date']);
                                    $currentDate = new DateTime();
                                    $interval = $currentDate->diff($creationDate);
                                    $daysWaiting = $interval->days;

                                    // Set the border color based on the waiting time
                                    $dateColor = ($daysWaiting >= 14) ? 'red' : '';
                                ?>
                                <div class="col-12 col-lg-6 mb-4">
                                    <div class="project-card card rounded-5 text-start border-2 shadow p-4" onclick="window.location.href='project.php?project_id=<?php echo $project['project_id']; ?>'">
                                        <div class="card-body p-2">
                                        <h5 class="card-title fw-bold">
                                            <?php echo $project['car_license'];  // Use car_license for the card title ?> 
                                        </h5>
                                        <div>
                                            <p class="card-text mb-4 fs-5"><?php echo $project['car_brand'] . ' ' . $project['car_model']; ?></p>
                                        </div>
                                            <div class="d-flex justify-content-between justify-content-md-start flex-wrap gap-2">
                                                <p class="card-text mb-0 me-md-auto"><strong>Kund:</strong><br> <?php echo $project['customer_fname'] . ' ' . $project['customer_lname']; ?></p>
                                                <p class="card-text mb-0 me-md-4 mx-2"><strong>Bokades:</strong><br> <span style="color: <?php echo $dateColor; ?>"><?php echo date('d.m.Y', strtotime($project['creation_date'])); ?> </span></p>
                                                <p class="card-text mb-0 ms-md-4"><strong>Senaste aktivitet:</strong><br> <?php if(!empty($project['most_recent_date'])) {echo date('d.m.Y', strtotime($project['most_recent_date']));} else { echo "Ingen aktivitet";}; ?></p>
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
