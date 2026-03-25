from fastapi import APIRouter
from pydantic import BaseModel
import httpx, os, json, re
from dotenv import load_dotenv

load_dotenv()
router = APIRouter()

class AlertasRequest(BaseModel):
    productos: list

@router.post("/alertas")
async def generar_alertas(data: AlertasRequest):
    prompt = f"""Analiza estos productos de inventario y genera alertas importantes.
Productos: {data.productos}
Responde SOLO en JSON sin backticks ni texto extra:
{{"alertas": [{{"producto_id": 1, "tipo": "stock_bajo", "mensaje": "texto", "prioridad": "alta"}}]}}"""

    async with httpx.AsyncClient() as client:
        response = await client.post(
            "https://api.anthropic.com/v1/messages",
            headers={
                "x-api-key": os.getenv("ANTHROPIC_API_KEY"),
                "anthropic-version": "2023-06-01",
                "Content-Type": "application/json"
            },
            json={
                "model": "claude-sonnet-4-20250514",
                "max_tokens": 1024,
                "messages": [{"role": "user", "content": prompt}]
            },
            timeout=30.0
        )

    texto = response.json()["content"][0]["text"]
    texto = re.sub(r'```json|```', '', texto).strip()
    return json.loads(texto)