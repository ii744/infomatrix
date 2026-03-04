import gradio as gr
import numpy as np

# Глобальні змінні
ai_enabled = False
current_language = "Українська"


def toggle_ai():
    global ai_enabled
    ai_enabled = not ai_enabled

    if ai_enabled:
        return (
            "AI працює",
            "Вимкнути AI",
            gr.update(visible=True),
            "Мікрофон активний — говоріть",
            "#95a5a6"
        )
    else:
        return (
            "AI вимкнено",
            "Увімкнути AI",
            gr.update(visible=False),
            "Мікрофон вимкнено",
            "#7f8c8d"
        )


def change_language(lang):
    global current_language
    current_language = lang
    return f"AI працює ({lang})" if ai_enabled else f"AI вимкнено ({lang})"


def process_audio(audio):
    """Обробка живого аудіо (заглушка)"""
    if not ai_enabled or audio is None:
        return "Мікрофон вимкнено або немає звуку"

    sample_rate, data = audio

    if len(data) == 0:
        return "Тиша"

    # Розрахунок RMS для гучності
    rms = np.sqrt(np.mean(data.astype(np.float32) ** 2))
    volume_level = min(rms * 15, 1.0)  # множник для чутливості

    if volume_level < 0.1:
        level = "Тихо"
        color = "#95a5a6"
    elif volume_level < 0.4:
        level = "Нормально"
        color = "#2ecc71"
    elif volume_level < 0.7:
        level = "Голосно"
        color = "#f39c12"
    else:
        level = "Дуже голосно!"
        color = "#e74c3c"

    bar = "█" * int(volume_level * 20)

    return f"Голос зафіксовано\nРівень: {level}\n{bar} ({volume_level:.2f})"


with gr.Blocks() as demo:
    gr.Markdown("### Аудіо Аналізатор (скелет)")

    with gr.Row():
        language_dropdown = gr.Dropdown(
            choices=["Українська", "English"],
            value="Українська",
            label="Мова інтерфейсу",
            container=False,
            scale=0
        )

        status = gr.Textbox(
            label="Статус",
            value="AI вимкнено",
            interactive=False,
            lines=1
        )

    toggle_button = gr.Button(
        value="Увімкнути AI",
        variant="primary",
        size="lg"
    )

    # Блок мікрофона (спочатку прихований)
    with gr.Column(visible=False) as mic_section:
        gr.Markdown("**Живий мікрофон** (говорите — бачите рівень звуку)")

        mic_input = gr.Audio(
            sources=["microphone"],  # ← правильний параметр у 6+
            type="numpy",
            label="Мікрофон (живий ввід)",
            streaming=True,  # ← активує стрімінг
            interactive=True
        )

        volume_indicator = gr.Textbox(
            label="Індикатор гучності",
            value="Мікрофон вимкнено",
            interactive=False,
            lines=3,
            elem_id="volume-bar"
        )

    ai_output = gr.Textbox(
        label="Результат AI",
        lines=6,
        interactive=False,
        placeholder="Після увімкнення тут з'явиться результат обробки..."
    )

    # Події
    toggle_button.click(
        toggle_ai,
        outputs=[status, toggle_button, mic_section, volume_indicator, volume_indicator]
    )

    language_dropdown.change(
        change_language,
        inputs=language_dropdown,
        outputs=status
    )

    # Стрімінг з мікрофона → оновлення індикатора
    mic_input.stream(
        process_audio,
        inputs=mic_input,
        outputs=volume_indicator
    )

# CSS для індикатора
demo.css = """
#volume-bar {
    font-family: monospace;
    white-space: pre;
    background-color: #2c3e50;
    color: white;
    padding: 12px;
    border-radius: 8px;
    min-height: 80px;
}
"""

demo.launch(
    theme=gr.themes.Soft(),
    share=True,  # публічний URL
    server_name="0.0.0.0"
)