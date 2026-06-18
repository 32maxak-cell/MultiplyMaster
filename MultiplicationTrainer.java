// MultiplicationTrainer.java - Тренажёр таблицы умножения на Java (CLI)
import java.util.Scanner;
import java.util.Random;

public class MultiplicationTrainer {
    private static Scanner scanner = new Scanner(System.in);
    private static Random random = new Random();

    public static int getDifficulty() {
        System.out.println("Выберите сложность:");
        System.out.println("1. Лёгкая (1-5)");
        System.out.println("2. Средняя (1-10)");
        System.out.println("3. Сложная (1-20)");
        while (true) {
            System.out.print("Ваш выбор (1-3): ");
            try {
                int choice = Integer.parseInt(scanner.nextLine());
                if (choice == 1) return 5;
                if (choice == 2) return 10;
                if (choice == 3) return 20;
                System.out.println("Пожалуйста, введите 1, 2 или 3.");
            } catch (NumberFormatException e) {
                System.out.println("Введите число.");
            }
        }
    }

    public static int getQuestionCount() {
        while (true) {
            System.out.print("Сколько примеров вы хотите решить? (1-50): ");
            try {
                int count = Integer.parseInt(scanner.nextLine());
                if (count >= 1 && count <= 50) return count;
                System.out.println("Пожалуйста, введите число от 1 до 50.");
            } catch (NumberFormatException e) {
                System.out.println("Введите число.");
            }
        }
    }

    public static void runTrainer(int maxNum, int totalQuestions) {
        int correct = 0;
        long start = System.currentTimeMillis();

        for (int i = 1; i <= totalQuestions; i++) {
            int a = random.nextInt(maxNum) + 1;
            int b = random.nextInt(maxNum) + 1;
            System.out.printf("\nПример %d/%d: %d x %d = ? ", i, totalQuestions, a, b);
            int userAnswer;
            try {
                userAnswer = Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {
                System.out.println("❌ Введите число.");
                userAnswer = -1;
            }
            int correctAnswer = a * b;
            if (userAnswer == correctAnswer) {
                System.out.println("✅ Правильно!");
                correct++;
            } else {
                System.out.printf("❌ Неправильно! Правильный ответ: %d\n", correctAnswer);
            }
        }

        long end = System.currentTimeMillis();
        double elapsed = (end - start) / 1000.0;
        double percent = (correct * 100.0) / totalQuestions;
        System.out.println("\n" + "=".repeat(30));
        System.out.println("📊 РЕЗУЛЬТАТЫ");
        System.out.printf("Всего примеров: %d\n", totalQuestions);
        System.out.printf("Правильных ответов: %d\n", correct);
        System.out.printf("Неправильных ответов: %d\n", totalQuestions - correct);
        System.out.printf("Процент правильных: %.1f%%\n", percent);
        System.out.printf("Время: %.2f сек.\n", elapsed);
        System.out.println("=".repeat(30));
    }

    public static void main(String[] args) {
        System.out.println("🧮 Тренажёр таблицы умножения");
        int maxNum = getDifficulty();
        int total = getQuestionCount();
        runTrainer(maxNum, total);
        System.out.print("Хотите повторить? (y/n): ");
        String again = scanner.nextLine().trim().toLowerCase();
        if (again.equals("y")) {
            main(args);
        } else {
            System.out.println("До свидания!");
        }
    }
}
