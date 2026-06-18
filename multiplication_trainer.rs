// multiplication_trainer.rs - Тренажёр таблицы умножения на Rust (CLI)
// Зависимости: rand = "0.8"
use rand::Rng;
use std::io::{self, Write};
use std::time::Instant;

fn get_difficulty() -> u32 {
    println!("Выберите сложность:");
    println!("1. Лёгкая (1-5)");
    println!("2. Средняя (1-10)");
    println!("3. Сложная (1-20)");
    loop {
        print!("Ваш выбор (1-3): ");
        io::stdout().flush().unwrap();
        let mut input = String::new();
        io::stdin().read_line(&mut input).expect("Ошибка ввода");
        match input.trim().parse::<u32>() {
            Ok(1) => return 5,
            Ok(2) => return 10,
            Ok(3) => return 20,
            _ => println!("Пожалуйста, введите 1, 2 или 3."),
        }
    }
}

fn get_question_count() -> u32 {
    loop {
        print!("Сколько примеров вы хотите решить? (1-50): ");
        io::stdout().flush().unwrap();
        let mut input = String::new();
        io::stdin().read_line(&mut input).expect("Ошибка ввода");
        match input.trim().parse::<u32>() {
            Ok(n) if n >= 1 && n <= 50 => return n,
            _ => println!("Пожалуйста, введите число от 1 до 50."),
        }
    }
}

fn run_trainer(max_num: u32, total_questions: u32) {
    let mut rng = rand::thread_rng();
    let mut correct = 0;
    let start = Instant::now();

    for i in 1..=total_questions {
        let a = rng.gen_range(1..=max_num);
        let b = rng.gen_range(1..=max_num);
        print!("\nПример {}/{}: {} x {} = ? ", i, total_questions, a, b);
        io::stdout().flush().unwrap();
        let mut input = String::new();
        io::stdin().read_line(&mut input).expect("Ошибка ввода");
        let user_answer: i32 = input.trim().parse().unwrap_or(-1);
        let correct_answer = (a * b) as i32;
        if user_answer == correct_answer {
            println!("✅ Правильно!");
            correct += 1;
        } else {
            println!("❌ Неправильно! Правильный ответ: {}", correct_answer);
        }
    }

    let elapsed = start.elapsed().as_secs_f64();
    let percent = (correct as f64 / total_questions as f64) * 100.0;
    println!("\n{}", "=".repeat(30));
    println!("📊 РЕЗУЛЬТАТЫ");
    println!("Всего примеров: {}", total_questions);
    println!("Правильных ответов: {}", correct);
    println!("Неправильных ответов: {}", total_questions - correct);
    println!("Процент правильных: {:.1}%", percent);
    println!("Время: {:.2} сек.", elapsed);
    println!("{}", "=".repeat(30));
}

fn main() {
    println!("🧮 Тренажёр таблицы умножения");
    let max_num = get_difficulty();
    let total = get_question_count();
    run_trainer(max_num, total);

    print!("Хотите повторить? (y/n): ");
    io::stdout().flush().unwrap();
    let mut again = String::new();
    io::stdin().read_line(&mut again).expect("Ошибка ввода");
    if again.trim().to_lowercase() == "y" {
        main();
    } else {
        println!("До свидания!");
    }
}
