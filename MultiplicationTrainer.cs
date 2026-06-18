// MultiplicationTrainer.cs - Тренажёр таблицы умножения на C# (CLI)
using System;

class MultiplicationTrainer
{
    static Random rand = new Random();

    static int GetDifficulty()
    {
        Console.WriteLine("Выберите сложность:");
        Console.WriteLine("1. Лёгкая (1-5)");
        Console.WriteLine("2. Средняя (1-10)");
        Console.WriteLine("3. Сложная (1-20)");
        while (true)
        {
            Console.Write("Ваш выбор (1-3): ");
            string input = Console.ReadLine();
            if (int.TryParse(input, out int choice))
            {
                if (choice == 1) return 5;
                if (choice == 2) return 10;
                if (choice == 3) return 20;
            }
            Console.WriteLine("Пожалуйста, введите 1, 2 или 3.");
        }
    }

    static int GetQuestionCount()
    {
        while (true)
        {
            Console.Write("Сколько примеров вы хотите решить? (1-50): ");
            string input = Console.ReadLine();
            if (int.TryParse(input, out int count) && count >= 1 && count <= 50)
                return count;
            Console.WriteLine("Пожалуйста, введите число от 1 до 50.");
        }
    }

    static void RunTrainer(int maxNum, int totalQuestions)
    {
        int correct = 0;
        DateTime start = DateTime.Now;

        for (int i = 1; i <= totalQuestions; i++)
        {
            int a = rand.Next(1, maxNum + 1);
            int b = rand.Next(1, maxNum + 1);
            Console.Write($"\nПример {i}/{totalQuestions}: {a} x {b} = ? ");
            string input = Console.ReadLine();
            int userAnswer;
            if (!int.TryParse(input, out userAnswer))
            {
                Console.WriteLine("❌ Введите число.");
                userAnswer = -1;
            }
            int correctAnswer = a * b;
            if (userAnswer == correctAnswer)
            {
                Console.WriteLine("✅ Правильно!");
                correct++;
            }
            else
            {
                Console.WriteLine($"❌ Неправильно! Правильный ответ: {correctAnswer}");
            }
        }

        TimeSpan elapsed = DateTime.Now - start;
        double percent = (correct * 100.0) / totalQuestions;
        Console.WriteLine("\n" + new string('=', 30));
        Console.WriteLine("📊 РЕЗУЛЬТАТЫ");
        Console.WriteLine($"Всего примеров: {totalQuestions}");
        Console.WriteLine($"Правильных ответов: {correct}");
        Console.WriteLine($"Неправильных ответов: {totalQuestions - correct}");
        Console.WriteLine($"Процент правильных: {percent:F1}%");
        Console.WriteLine($"Время: {elapsed.TotalSeconds:F2} сек.");
        Console.WriteLine(new string('=', 30));
    }

    static void Main()
    {
        Console.WriteLine("🧮 Тренажёр таблицы умножения");
        int maxNum = GetDifficulty();
        int total = GetQuestionCount();
        RunTrainer(maxNum, total);
        Console.Write("Хотите повторить? (y/n): ");
        string again = Console.ReadLine().Trim().ToLower();
        if (again == "y")
            Main();
        else
            Console.WriteLine("До свидания!");
    }
}
