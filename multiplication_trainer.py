#!/usr/bin/env python3
"""
multiplication_trainer.py - Тренажёр таблицы умножения на Python (CLI)
"""
import random
import time

def get_difficulty():
    print("Выберите сложность:")
    print("1. Лёгкая (1-5)")
    print("2. Средняя (1-10)")
    print("3. Сложная (1-20)")
    while True:
        try:
            choice = int(input("Ваш выбор (1-3): "))
            if choice == 1:
                return 5
            elif choice == 2:
                return 10
            elif choice == 3:
                return 20
            else:
                print("Пожалуйста, введите 1, 2 или 3.")
        except ValueError:
            print("Введите число.")

def get_question_count():
    while True:
        try:
            count = int(input("Сколько примеров вы хотите решить? (1-50): "))
            if 1 <= count <= 50:
                return count
            print("Пожалуйста, введите число от 1 до 50.")
        except ValueError:
            print("Введите число.")

def run_trainer(max_num, total_questions):
    correct = 0
    start_time = time.time()
    for i in range(1, total_questions + 1):
        a = random.randint(1, max_num)
        b = random.randint(1, max_num)
        print(f"\nПример {i}/{total_questions}: {a} x {b} = ? ", end="")
        try:
            user_answer = int(input())
        except ValueError:
            print("❌ Введите число.")
            user_answer = -1
        correct_answer = a * b
        if user_answer == correct_answer:
            print("✅ Правильно!")
            correct += 1
        else:
            print(f"❌ Неправильно! Правильный ответ: {correct_answer}")
    end_time = time.time()
    elapsed = end_time - start_time
    percent = (correct / total_questions) * 100
    print("\n" + "="*30)
    print("📊 РЕЗУЛЬТАТЫ")
    print(f"Всего примеров: {total_questions}")
    print(f"Правильных ответов: {correct}")
    print(f"Неправильных ответов: {total_questions - correct}")
    print(f"Процент правильных: {percent:.1f}%")
    print(f"Время: {elapsed:.2f} сек.")
    print("="*30)

def main():
    print("🧮 Тренажёр таблицы умножения")
    max_num = get_difficulty()
    total = get_question_count()
    run_trainer(max_num, total)
    again = input("Хотите повторить? (y/n): ").strip().lower()
    if again == 'y':
        main()
    else:
        print("До свидания!")

if __name__ == "__main__":
    main()
