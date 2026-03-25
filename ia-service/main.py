from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from routers import prediccion, alertas, riesgo

app = FastAPI(title="Inventario IA Service")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost:8000"],
    allow_methods=["*"],
    allow_headers=["*"],
)

app.include_router(prediccion.router, prefix="/ia")
app.include_router(alertas.router, prefix="/ia")
app.include_router(riesgo.router, prefix="/ia")

@app.get("/")
def root():
    return {"status": "IA Service corriendo"}