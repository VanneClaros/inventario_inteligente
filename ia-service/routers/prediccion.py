
from fastapi import APIRouter
from pydantic import BaseModel
import httpx, os
from dotenv import load_dotenv

load_dotenv()
router = APIRouter()

class ProductoRequest(BaseModel):
    producto_id: int
    nombre: str
    historial: list = []

@router.post("/predecir")
async def predecir_demanda(data: ProductoRequest):
    prompt = f"""Eres experto en inventario. Analiza el historial de ventas del producto '{data.nombre}'.
Historial: {data.historial}
Responde SOLO en JSON sin backticks:
{{"prediccion_proximos_30_dias": 0, "tendencia": "estable", "confianza": 0.8, "recomendacion_stock": 0, "observaciones": "texto"}}"""

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
    import json, re
    texto = response.json()["content"][0]["text"]
    texto = re.sub(r'```json|```', '', texto).strip()
    return json.loads(texto)