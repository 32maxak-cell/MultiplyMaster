// multiplication_trainer.go - Тренажёр таблицы умножения на Go (CLI)
package main

import (
    "bufio"
    "fmt"
    "math/rand"
    "os"
    "strconv"
    "strings"
    "time"
)

func getDifficulty() int {
    fmt.Println("Выберите сложность:")
    fmt.Println("1. Лёгкая (1-5)")
    fmt.Println("2. Средняя (1-10)")
    fmt.Println("3. Сложная (1-20)")
    reader := bufio.NewReader(os.Stdin)
    for {
        fmt.Print("Ваш выбор (1-3): ")
        input, _ := reader.ReadString('\n')
        input = strings.TrimSpace(input)
        choice, err := strconv.Atoi(input)
        if err == nil && choice >= 1 && choice <= 3 {
            switch choice {
            case 1:
                return 5
            case 2:
                return 10
            case 3:
                return 20
            }
        }
        fmt.Println("Пожалуйста, введите 1, 2 или 3.")
    }
}

func getQuestionCount() int {
    reader := bufio.NewReader(os.Stdin)
    for {
        fmt.Print("Сколько примеров вы хотите решить? (1-50): ")
        input, _ := reader.ReadString('\n')
        input = strings.TrimSpace(input)
        count, err := strconv.Atoi(input)
        if err == nil && count >= 1 && count <= 50 {
            return count
        }
        fmt.Println("Пожалуйста, введите число от 1 до 50.")
    }
}

func runTrainer(maxNum, totalQuestions int) {
    reader := bufio.NewReader(os.Stdin)
    correct := 0
    start := time.Now()
    for i := 1; i <= totalQuestions; i++ {
        a := rand.Intn(maxNum) + 1
        b := rand.Intn(maxNum) + 1
        fmt.Printf("\nПример %d/%d: %d x %d = ? ", i, totalQuestions, a, b)
        input, _ := reader.ReadString('\n')
        input = strings.TrimSpace(input)
        userAnswer, err := strconv.Atoi(input)
        correctAnswer := a * b
        if err == nil && userAnswer == correctAnswer {
            fmt.Println("✅ Правильно!")
            correct++
        } else {
            fmt.Printf("❌ Неправильно! Правильный ответ: %d\n", correctAnswer)
        }
    }
    elapsed := time.Since(start).Seconds()
    percent := float64(correct) / float64(totalQuestions) * 100
    fmt.Println("\n" + strings.Repeat("=", 30))
    fmt.Println("📊 РЕЗУЛЬТАТЫ")
    fmt.Printf("Всего примеров: %d\n", totalQuestions)
    fmt.Printf("Правильных ответов: %d\n", correct)
    fmt.Printf("Неправильных ответов: %d\n", totalQuestions-correct)
    fmt.Printf("Процент правильных: %.1f%%\n", percent)
    fmt.Printf("Время: %.2f сек.\n", elapsed)
    fmt.Println(strings.Repeat("=", 30))
}

func main() {
    rand.Seed(time.Now().UnixNano())
    fmt.Println("🧮 Тренажёр таблицы умножения")
    maxNum := getDifficulty()
    total := getQuestionCount()
    runTrainer(maxNum, total)
    fmt.Print("Хотите повторить? (y/n): ")
    reader := bufio.NewReader(os.Stdin)
    again, _ := reader.ReadString('\n')
    again = strings.TrimSpace(strings.ToLower(again))
    if again == "y" {
        main()
    } else {
        fmt.Println("До свидания!")
    }
}
