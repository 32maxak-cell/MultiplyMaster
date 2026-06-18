// multiplication_trainer.js - Тренажёр таблицы умножения на JavaScript (Node.js CLI)
const readline = require('readline');
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const prompt = (query) => new Promise(resolve => rl.question(query, resolve));

async function getDifficulty() {
    console.log("Выберите сложность:");
    console.log("1. Лёгкая (1-5)");
    console.log("2. Средняя (1-10)");
    console.log("3. Сложная (1-20)");
    while (true) {
        const choice = await prompt("Ваш выбор (1-3): ");
        const num = parseInt(choice);
        if (num === 1) return 5;
        if (num === 2) return 10;
        if (num === 3) return 20;
        console.log("Пожалуйста, введите 1, 2 или 3.");
    }
}

async function getQuestionCount() {
    while (true) {
        const input = await prompt("Сколько примеров вы хотите решить? (1-50): ");
        const count = parseInt(input);
        if (count >= 1 && count <= 50) return count;
        console.log("Пожалуйста, введите число от 1 до 50.");
    }
}

async function runTrainer(maxNum, totalQuestions) {
    let correct = 0;
    const start = Date.now();
    for (let i = 1; i <= totalQuestions; i++) {
        const a = Math.floor(Math.random() * maxNum) + 1;
        const b = Math.floor(Math.random() * maxNum) + 1;
        const answer = a * b;
        const userAnswer = await prompt(`\nПример ${i}/${totalQuestions}: ${a} x ${b} = ? `);
        const parsed = parseInt(userAnswer);
        if (parsed === answer) {
            console.log("✅ Правильно!");
            correct++;
        } else {
            console.log(`❌ Неправильно! Правильный ответ: ${answer}`);
        }
    }
    const elapsed = (Date.now() - start) / 1000;
    const percent = (correct / totalQuestions) * 100;
    console.log("\n" + "=".repeat(30));
    console.log("📊 РЕЗУЛЬТАТЫ");
    console.log(`Всего примеров: ${totalQuestions}`);
    console.log(`Правильных ответов: ${correct}`);
    console.log(`Неправильных ответов: ${totalQuestions - correct}`);
    console.log(`Процент правильных: ${percent.toFixed(1)}%`);
    console.log(`Время: ${elapsed.toFixed(2)} сек.`);
    console.log("=".repeat(30));
}

async function main() {
    console.log("🧮 Тренажёр таблицы умножения");
    const maxNum = await getDifficulty();
    const total = await getQuestionCount();
    await runTrainer(maxNum, total);
    const again = await prompt("Хотите повторить? (y/n): ");
    if (again.toLowerCase() === 'y') {
        await main();
    } else {
        console.log("До свидания!");
        rl.close();
    }
}

main().catch(console.error);
