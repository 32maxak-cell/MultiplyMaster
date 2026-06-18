<?php
// multiplication_trainer.php - Тренажёр таблицы умножения на PHP (веб)
session_start();

// Сброс сессии при новом старте
if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Инициализация сессии
if (!isset($_SESSION['questions'])) {
    $_SESSION['questions'] = [];
    $_SESSION['current'] = 0;
    $_SESSION['correct'] = 0;
    $_SESSION['total'] = 0;
    $_SESSION['start_time'] = time();
    $_SESSION['finished'] = false;
    $_SESSION['max_num'] = 10;
    $_SESSION['count'] = 10;
}

// Обработка выбора сложности и количества
if (isset($_POST['start'])) {
    $difficulty = (int)$_POST['difficulty'];
    $_SESSION['max_num'] = ($difficulty == 1) ? 5 : (($difficulty == 2) ? 10 : 20);
    $_SESSION['count'] = (int)$_POST['count'];
    if ($_SESSION['count'] < 1 || $_SESSION['count'] > 50) $_SESSION['count'] = 10;
    // Генерация вопросов
    $_SESSION['questions'] = [];
    for ($i = 0; $i < $_SESSION['count']; $i++) {
        $a = rand(1, $_SESSION['max_num']);
        $b = rand(1, $_SESSION['max_num']);
        $_SESSION['questions'][] = ['a' => $a, 'b' => $b, 'answer' => $a * $b];
    }
    $_SESSION['current'] = 0;
    $_SESSION['correct'] = 0;
    $_SESSION['total'] = 0;
    $_SESSION['start_time'] = time();
    $_SESSION['finished'] = false;
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Обработка ответа
if (isset($_POST['answer']) && !$_SESSION['finished']) {
    $userAnswer = (int)$_POST['answer'];
    $current = $_SESSION['current'];
    if ($current < count($_SESSION['questions'])) {
        $q = $_SESSION['questions'][$current];
        $_SESSION['total']++;
        if ($userAnswer == $q['answer']) {
            $_SESSION['correct']++;
            $feedback = "✅ Правильно!";
        } else {
            $feedback = "❌ Неправильно! Правильный ответ: " . $q['answer'];
        }
        $_SESSION['current']++;
        if ($_SESSION['current'] >= count($_SESSION['questions'])) {
            $_SESSION['finished'] = true;
        }
        // Сохраняем feedback в сессию для отображения
        $_SESSION['feedback'] = $feedback;
        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        exit;
    }
}

// Отображение
$questions = $_SESSION['questions'];
$currentIdx = $_SESSION['current'];
$total = $_SESSION['total'];
$correct = $_SESSION['correct'];
$finished = $_SESSION['finished'];
$feedback = isset($_SESSION['feedback']) ? $_SESSION['feedback'] : '';
$max_num = $_SESSION['max_num'];
$count = $_SESSION['count'];

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧮 Тренажёр таблицы умножения (PHP)</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7fb; margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { max-width: 600px; width: 100%; background: white; padding: 30px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 120px; }
        input, select, button { padding: 8px 12px; border-radius: 6px; border: 1px solid #ccc; }
        button { background: #3498db; color: white; border: none; cursor: pointer; }
        button:hover { background: #2980b9; }
        .question { font-size: 24px; text-align: center; margin: 30px 0; }
        .feedback { text-align: center; font-size: 18px; margin: 20px 0; padding: 10px; border-radius: 8px; }
        .feedback.correct { background: #d5f5e3; color: #27ae60; }
        .feedback.wrong { background: #fadbd8; color: #e74c3c; }
        .stats { background: #ecf0f1; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .progress { margin-top: 10px; }
        .result { text-align: center; font-size: 18px; margin-top: 20px; }
        .btn-reset { background: #e67e22; }
        .btn-reset:hover { background: #d35400; }
    </style>
</head>
<body>
<div class="container">
    <h1>🧮 Тренажёр таблицы умножения</h1>

    <?php if (empty($questions) || $finished): ?>
        <!-- Форма настройки -->
        <form method="POST">
            <div class="form-group">
                <label>Сложность:</label>
                <select name="difficulty">
                    <option value="1">Лёгкая (1-5)</option>
                    <option value="2" selected>Средняя (1-10)</option>
                    <option value="3">Сложная (1-20)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Количество примеров:</label>
                <input type="number" name="count" value="10" min="1" max="50">
            </div>
            <button type="submit" name="start">▶️ Начать</button>
        </form>
        <?php if ($finished): ?>
            <div class="result">
                <p><strong>📊 Результаты</strong></p>
                <p>Всего примеров: <?= $total ?></p>
                <p>Правильных ответов: <?= $correct ?></p>
                <p>Неправильных ответов: <?= $total - $correct ?></p>
                <p>Процент: <?= $total > 0 ? round(($correct / $total) * 100, 1) : 0 ?>%</p>
                <p>Время: <?= time() - $_SESSION['start_time'] ?> сек.</p>
                <a href="?reset=1" class="btn-reset" style="display:inline-block; padding:8px 16px; background:#e67e22; color:white; text-decoration:none; border-radius:6px;">🔄 Начать заново</a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <!-- Процесс тестирования -->
        <div class="progress">
            Вопрос <?= $currentIdx + 1 ?> из <?= count($questions) ?>
        </div>
        <?php if ($feedback): ?>
            <div class="feedback <?= strpos($feedback, 'Правильно') !== false ? 'correct' : 'wrong' ?>">
                <?= $feedback ?>
            </div>
        <?php endif; ?>
        <?php if ($currentIdx < count($questions)): 
            $q = $questions[$currentIdx];
        ?>
            <div class="question">
                <?= $q['a'] ?> × <?= $q['b'] ?> = ?
            </div>
            <form method="POST">
                <input type="number" name="answer" autofocus required style="width:100%; padding:12px; font-size:20px; text-align:center;">
                <button type="submit" style="width:100%; margin-top:10px;">✅ Ответить</button>
            </form>
        <?php endif; ?>
        <div style="margin-top:15px;">
            <a href="?reset=1" class="btn-reset" style="display:inline-block; padding:8px 16px; background:#e67e22; color:white; text-decoration:none; border-radius:6px;">🔄 Сбросить</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
