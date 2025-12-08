# Скрипты

## download-openapi-scheme.php

Скрипт для автоматического скачивания и обновления OpenAPI схемы с fkwallet.io.

### Использование

```bash
php scripts/download-openapi-scheme.php
```

Скрипт:
- Скачивает актуальную версию OpenAPI схемы с `https://fkwallet.io/openapi-scheme-ru.json`
- Сохраняет её в `schemas/openapi-scheme-ru.json`
- Форматирует JSON для читаемости
- Показывает сообщение, если файл изменился

### Автоматическое обновление

Скрипт автоматически запускается перед каждым `git push` благодаря Git pre-push hook (`.git/hooks/pre-push`).

Если схема изменилась:
- Файл автоматически добавляется в staging area
- Вы получите уведомление с рекомендацией сделать commit

### Ручной запуск

Вы можете запустить скрипт вручную в любое время:

```bash
php scripts/download-openapi-scheme.php
```

