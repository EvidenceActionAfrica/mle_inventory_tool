<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Reconfirmation Report</h3>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
            <li class="breadcrumb-item">Reports</li>
            <li class="breadcrumb-item">Reconfirmation Report</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                This report shows all confirmation entries  for all assigned inventory.
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-table me-1"></i> Filter</span>
            </div>

            <div class="card-body">
                <form method="GET" action="">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="year" class="form-label">Year:</label>
                            <select name="year" class="form-select">
                                <option value="">--All--</option>
                                <?php
                                for ($y = 2023; $y <= date('Y') + 1; $y++) {
                                    echo "<option value=\"$y\" " . (isset($_GET['year']) && $_GET['year'] == $y ? 'selected' : '') . ">$y</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="month" class="form-label">Month:</label>
                            <select name="month" class="form-select">
                                <option value="">--All--</option>
                                <?php
                                for ($m = 1; $m <= 12; $m++) {
                                    $monthName = date('F', mktime(0, 0, 0, $m, 10));
                                    echo "<option value=\"$m\" " . (isset($_GET['month']) && $_GET['month'] == $m ? 'selected' : '') . ">$monthName</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> 
            </div>
            <div class="card-body table-responsive">
                <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Item</th>
                        <th>Serial Number</th>
                        <th>Tag Number</th>
                        <th>Managed By</th>
                        <th>Assigned Date</th>
                        <th>Confirmation Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportData as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['position'] . ' - ' . $row['department']); ?></td>
                            <td><?= htmlspecialchars($row['item']); ?></td>
                            <td><?= htmlspecialchars($row['serial_number']); ?></td>
                            <td><?= htmlspecialchars($row['tag_number']); ?></td>
                            <td><?= htmlspecialchars($row['managed_by']); ?></td>
                            <td><?= htmlspecialchars($row['date_assigned']); ?></td>
                            <td><?= htmlspecialchars($row['log_confirmation_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            </div>
        </div>
    </div>
</main>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const datatable = document.getElementById('datatablesSimple');
        if (datatable) {
            new simpleDatatables.DataTable(datatable);
        }
    });
</script>
