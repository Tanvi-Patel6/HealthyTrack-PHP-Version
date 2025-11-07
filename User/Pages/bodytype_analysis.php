<?php 
session_start(); 
$page_title = "HealthyTrack - BodyType Form"; 

require_once __DIR__ . '/../config/db.php'; 
require_once __DIR__ . '/../includes/auth_check.php'; 
require_once __DIR__ . '/../includes/header.php'; 

$user_id = $_SESSION['user_id'] ?? 0;

$height = $weight = $age = $gender = $goal = $blood_group = $type = "";
$message = "";
$readonly = "";
$button_text = "Submit";

$result = mysqli_query($cn, "SELECT * FROM body_type WHERE user_id=$user_id");
$existing = mysqli_fetch_assoc($result);

if ($existing) {
    $height      = $existing['height'];
    $weight      = $existing['weight'];
    $age         = $existing['age'];
    $gender      = $existing['gender'];
    $goal        = $existing['goal'];
    $blood_group = $existing['blood_group'];
    $type        = $existing['type'];
    $readonly    = "disabled";
    $button_text = "Save Changes";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['insert'])) {
    $height      = $_POST['height'] ?? "";
    $weight      = $_POST['weight'] ?? "";
    $age         = $_POST['age'] ?? "";
    $gender      = $_POST['gender'] ?? "";
    $goal        = $_POST['goal'] ?? "";
    $blood_group = isset($_POST['blood_group']) ? strtoupper($_POST['blood_group']) : "";
    $type        = $_POST['type'] ?? "";

    if ($height <= 0) $message = "Invalid height.";
    elseif ($weight <= 0) $message = "Invalid weight.";
    elseif ($age <= 0 || $age > 120) $message = "Invalid age (1-120).";
    elseif (!in_array($gender, ['male','female','other'])) $message = "Invalid gender.";
    elseif (!in_array($goal, ['loss','gain','maintain'])) $message = "Invalid goal.";
    elseif ($blood_group === "") $message = "Invalid blood group.";
    elseif (!in_array($type, ['veg','both'])) $message = "Invalid food preference.";
    else {
        if ($existing) {
            $Query = "UPDATE body_type SET height='$height', weight='$weight', age='$age', gender='$gender', goal='$goal', blood_group='$blood_group', type='$type' WHERE user_id=$user_id";
        } else {
            $Query = "INSERT INTO body_type (user_id,height,weight,age,gender,goal,blood_group,type) VALUES ('$user_id','$height','$weight','$age','$gender','$goal','$blood_group','$type')";
        }

        if (mysqli_query($cn, $Query)) {
            $message = "Form saved successfully!";
            $readonly = "disabled";
            $button_text = "Save Changes";
            $existing = [
                'height' => $height,
                'weight' => $weight,
                'age' => $age,
                'gender' => $gender,
                'goal' => $goal,
                'blood_group' => $blood_group,
                'type' => $type
            ];
        } else {
            $message = "Error saving form: " . mysqli_error($cn);
        }
    }
}
?>
<head>
<style>
/* ======= ADVANCED MODERN CSS ======= */

body {
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    color: white;
}

.hero { 
    display: flex; 
    align-items: center; 
    justify-content: center;
    height: 100vh;
    padding: ;
    position: relative;
    overflow: hidden;
}



.form-card {
    position: relative;
    z-index: 2;
    backdrop-filter: blur(20px);
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 1.5rem; 
    padding: 2.5rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    width: 100%; 
    max-width: 600px; 
    height:90vh;
    animation: fadeIn 1s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

h3 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 1.5rem;
    letter-spacing: 1px;
}

.form-control, .form-select {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255,255,255,0.2);
    color: black;
    border-radius: 10px;
    transition: all 0.3s ease;
}

input {
    color:white;
}

.form-control:focus, .form-select:focus {
    border-color: #071216ff;
    box-shadow: 0 0 8px #06101392;
    background: rgba(255,255,255,0.25);
}

label {
    color: #cfd2dc;
}

.btn-custom { 
    background: linear-gradient(90deg, #6a11cb, #2575fc);
    color: #fff;
    border: none; 
    border-radius: 12px; 
    padding: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease; 
    margin-top: 10px; 
}

.btn-custom:hover { 
    background: linear-gradient(90deg, #2575fc, #6a11cb);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(37,117,252,0.3);
}

.btn-edit { 
    background: linear-gradient(90deg, #ff9800, #ffb74d);
    border: none;
    border-radius: 12px; 
    padding: 0.8rem; 
    font-weight: 600; 
    color: white;
    transition: all 0.3s ease;
}

.btn-edit:hover {
    background: linear-gradient(90deg, #ffb74d, #ff9800);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255,152,0,0.4);
}

.error { 
    color: #ff8080; 
    font-size: 0.9rem; 
    margin-top: 5px; 
    display: block; 
}

p {
    font-size: 1rem;
    text-align: center;
    margin-top: 15px;
}

@media (max-width: 600px) {
    .form-card {
        padding: 1.5rem;
    }
    .hero {
        padding: 1rem;
    }
}
</style>
</head>

<body>
<section class="hero">
<div class="form-card">
<h3 class="text-center">📝 Body Analysis Form</h3>
<form method="post" id="bodyForm" onsubmit="return validation(event)">

<div class="row g-3">
<div class="col-md-6 form-floating">
<input type="number" class="form-control" id="height" name="height" placeholder="Height" value="<?= $height ?>" <?= $readonly ?>>
<label for="height"><i class="bi bi-rulers"></i> Height (cm)</label>
<span class="error" id="height-error"></span>
</div>
<div class="col-md-6 form-floating">
<input type="number" class="form-control" id="weight" name="weight" placeholder="Weight" value="<?= $weight ?>" <?= $readonly ?>>
<label for="weight"><i class="bi bi-activity"></i> Weight (kg)</label>
<span class="error" id="weight-error"></span>
</div>
</div>

<div class="form-floating my-3">
<input type="number" class="form-control" id="age" name="age" placeholder="Age" value="<?= $age ?>" <?= $readonly ?>>
<label for="age"><i class="bi bi-hourglass-split"></i> Age</label>
<span class="error" id="age-error"></span>
</div>

<div class="form-floating my-3">
<select class="form-select" id="gender" name="gender" <?= $readonly ?>>
<option value="" disabled <?= empty($gender) ? 'selected' : '' ?>>Choose...</option>
<option value="male" <?= ($gender=='male')?'selected':'' ?>>Male</option>
<option value="female" <?= ($gender=='female')?'selected':'' ?>>Female</option>
<option value="other" <?= ($gender=='other')?'selected':'' ?>>Other</option>
</select>
<label for="gender"><i class="bi bi-gender-ambiguous"></i> Gender</label>
<span class="error" id="gender-error"></span>
</div>

<div class="form-floating my-3">
<select class="form-select" id="goal" name="goal" <?= $readonly ?>>
<option value="" disabled <?= empty($goal) ? 'selected' : '' ?>>Choose...</option>
<option value="loss" <?= ($goal=='loss')?'selected':'' ?>>Weight Loss</option>
<option value="gain" <?= ($goal=='gain')?'selected':'' ?>>Weight Gain</option>
<option value="maintain" <?= ($goal=='maintain')?'selected':'' ?>>Maintain</option>
</select>
<label for="goal"><i class="bi bi-bullseye"></i> Goal</label>
<span class="error" id="goal-error"></span>
</div>

<div class="form-floating my-3">
<input type="text" class="form-control" id="blood_group" name="blood_group" placeholder="Blood Group" value="<?= $blood_group ?>" <?= $readonly ?>>
<label for="blood_group"><i class="bi bi-droplet-fill text-danger"></i> Blood Group</label>
<span class="error" id="blood-error"></span>
</div>

<div class="form-floating my-3">
<select class="form-select" id="type" name="type" <?= $readonly ?>>
<option value="" disabled <?= empty($type) ? 'selected' : '' ?>>Choose...</option>
<option value="veg" <?= ($type=='veg')?'selected':'' ?>>Vegetarian</option>
<option value="both" <?= ($type=='both')?'selected':'' ?>>Both (Non-Veg & Veg)</option>
</select>
<label for="type"><i class="bi bi-egg-fried"></i> Food Preference</label>
<span class="error" id="type-error"></span>
</div>

<button type="submit" class="btn btn-custom w-100" name="insert" id="submit-btn"><?= $button_text ?></button>

<?php if($existing) { ?>
<button type="button" class="btn btn-edit w-100 mt-2" id="edit-btn">✏️ Edit</button>
<?php } ?>

<?php if(!empty($message)) echo "<p>$message</p>"; ?>

</form>
</div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<script>
function validation(e){
    document.querySelectorAll('.error').forEach(span=>span.textContent="");

    const height = document.getElementById('height').value.trim();
    const weight = document.getElementById('weight').value.trim();
    const age = document.getElementById('age').value.trim();
    const gender = document.getElementById('gender').value;
    const goal = document.getElementById('goal').value;
    const blood_group = document.getElementById('blood_group').value.trim();
    const type = document.getElementById('type').value;

    if(height==""||height<=0){ document.getElementById('height-error').textContent="Enter valid height"; e.preventDefault(); return false; }
    if(weight==""||weight<=0){ document.getElementById('weight-error').textContent="Enter valid weight"; e.preventDefault(); return false; }
    if(age==""||age<=0||age>120){ document.getElementById('age-error').textContent="Enter valid age"; e.preventDefault(); return false; }
    if(gender==""){ document.getElementById('gender-error').textContent="Select gender"; e.preventDefault(); return false; }
    if(goal==""){ document.getElementById('goal-error').textContent="Select goal"; e.preventDefault(); return false; }
    if(blood_group==""){ document.getElementById('blood-error').textContent="Enter blood group"; e.preventDefault(); return false; }
    if(type==""){ document.getElementById('type-error').textContent="Select food type"; e.preventDefault(); return false; }

    return true;
}

document.getElementById('edit-btn')?.addEventListener('click', ()=>{
    document.querySelectorAll('input, select').forEach(field => field.removeAttribute('disabled'));
    document.getElementById('submit-btn').textContent = "💾 Save Changes";
    document.getElementById('edit-btn').style.display = "none";
});
</script>
