
from fastapi import APIRouter
from pydantic import BaseModel
import httpx, os, json, re
from dotenv import load_dotenv

load_dotenv()
router = APIRouter()

class RiesgoRequest(BaseModel):
    producto_id: int
    nombre: str
    stock_actual: int
    stock_minimo: int = 0
    precio: float = 0

@router.post("/riesgo")
async def calcular_riesgo(data: RiesgoRequest):
    prompt = f"""Analiza este producto y calcula riesgo de quiebre de stock.
Datos: {data.dict()}
Responde SOLO en JSON sin backticks:
{{"score_riesgo": 50, "nivel": "medio", "dias_estimados_agotamiento": 15, "accion_recomendada": "texto"}}"""

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
                "max_tokens": 512,
                "messages": [{"role": "user", "content": prompt}]
            },
            timeout=30.0
        )
    texto = response.json()["content"][0]["text"]
    texto = re.sub(r'```json|```', '', texto).strip()
    return json.loads(texto)
