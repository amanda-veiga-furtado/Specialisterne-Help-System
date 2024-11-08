import sys #biblioteca para manipular o que está sendo digitado na caixa de texto
import io #biblioteca de comunicação entre cliente e servidor

# saída padrão para UTF-8
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

# Junta tudo que foi digitado em uma única string e converte para minúsculas
user_message = ' '.join(sys.argv[1:]).lower()

# Respostas simples baseadas na entrada do usuário
if "olá" in user_message or "oi" in user_message:
    response = "Olá! Como posso ajudar você hoje?"
elif "forum 1" in user_message:
    response = "Para ir para este fórum 1 basta clicar no link:"
elif "forum 2" in user_message:
    response = "Para ir para este fórum 2 basta clicar no link"
elif "forum 3" in user_message:
    response = "Para ir para este fórum 3 basta clicar no link"
else:
    response = "Desculpe, não entendi. Pode reformular?"

print(response)
