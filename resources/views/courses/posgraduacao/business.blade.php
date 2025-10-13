@extends('layout.fe_master')
@section('content')
    <style>
        :root {
            --gradient-accent: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --primary-color: #f87808;
            --primary-dark: #9e5007;
            --text-dark: #343a40;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: var(--gradient-accent);
            background-size: 100% 100%;
            animation: gradientAnimation 1s ease infinite;
            color: black;
            overflow-x: hidden;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .course-banner {
            height: 60vh;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            padding: 0 20px;
        }

        .course-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .course-banner-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }

        .course-banner h1 {
            font-size: 48px;
            margin: 0;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
            color: var(--primary-color);
        }

        .course-banner p {
            font-size: 20px;
            margin: 20px 0;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        .course-section,
        .curriculum-section {
            padding: 5rem 5%;
            background-color: #fff;
            color: var(--text-dark);
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), transparent);
            border-radius: 2px;
        }

        .course-details {
            display: flex;
            flex-wrap: wrap;
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .course-info {
            flex: 1;
            min-width: 300px;
        }

        .course-info-card {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .info-item {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
        }

        .info-item i {
            color: var(--primary-color);
            margin-right: 15px;
            font-size: 1.2rem;
            margin-top: 3px;
        }

        .info-item h3 {
            margin: 0 0 5px 0;
            font-size: 1.2rem;
        }

        .info-item p {
            margin: 0;
            color: #666;
        }

        .course-description {
            flex: 2;
            min-width: 300px;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .course-description h3 {
            color: var(--primary-color);
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .course-description ul {
            padding-left: 20px;
        }

        .course-description li {
            margin-bottom: 10px;
        }

        .simple-curriculum {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 0;
        }

        .semester-box {
            width: 320px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .semester-title {
            background-color: #f5f5f5;
            color: var(--primary-dark);
            padding: 12px 15px;
            font-size: 1.1rem;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .courses-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .course-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
        }

        .course-row:last-child {
            border-bottom: none;
        }

        .course-credits {
            color: var(--primary-color);
            font-weight: 500;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @media (max-width: 768px) {
            .course-banner {
                height: 50vh;
            }

            .course-banner h1 {
                font-size: 36px;
            }

            .course-banner p {
                font-size: 16px;
            }

            .section-title {
                font-size: 2rem;
            }

            .course-details {
                flex-direction: column;
            }
        }
    </style>

<div class="course-banner" style="background-image: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="course-banner-content">
        <h1>Business Analytics</h1>
        <p>Especialização prática em análise de dados e tomada de decisão orientada por informação</p>
    </div>
</div>

<section class="course-section">
    <div class="section-container">
        <h2 class="section-title">Sobre o Curso</h2>
        <div class="course-details">
            <div class="course-info">
                <div class="course-info-card">
                    <div class="info-item">
                        <i class="fas fa-graduation-cap"></i>
                        <div>
                            <h3>Grau Académico</h3>
                            <p>Pós-graduação (1 semestre)</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Duração</h3>
                            <p>6 meses (30 ECTS)</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <h3>Regime</h3>
                            <p>Pós-laboral</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Localização</h3>
                            <p>Lisboa / Online</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-money-bill-wave"></i>
                        <div>
                            <h3>Propina Mensal</h3>
                            <p>Consultar instituição</p>
                        </div>
                    </div>
                </div>

                <div class="course-info-card">
                    <h3 style="color: var(--primary-color); margin-top: 0;">Áreas de Atuação</h3>
                    <ul>
                        <li>Análise de Dados</li>
                        <li>Business Intelligence</li>
                        <li>Consultoria Estratégica</li>
                        <li>Gestão de Informação</li>
                        <li>Ciência de Dados</li>
                    </ul>
                </div>
            </div>

            <div class="course-description">
                <p>A Pós-Graduação em Business Analytics do ISTEC capacita profissionais a dominar ferramentas analíticas e transformar dados em insights estratégicos. Com foco em metodologias práticas e casos reais, o curso prepara para uma atuação eficaz no cenário competitivo atual.</p>

                <h3>Objetivos do Curso</h3>
                <ul>
                    <li>Capacitar na utilização de ferramentas de análise de dados</li>
                    <li>Aplicar técnicas de visualização e reporting</li>
                    <li>Compreender indicadores de performance</li>
                    <li>Interpretar dados para tomada de decisão</li>
                    <li>Desenvolver soluções baseadas em dados</li>
                </ul>

                <h3>Diferenciais</h3>
                <ul>
                    <li>Formadores com experiência no mercado</li>
                    <li>Metodologia orientada a projetos reais</li>
                    <li>Ambiente de aprendizagem colaborativo</li>
                    <li>Infraestrutura moderna e acesso a software especializado</li>
                    <li>Flexibilidade: presencial ou online</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="curriculum-section">
    <div class="section-container">
        <h2 class="section-title">Plano Curricular</h2>

        <div class="simple-curriculum">
            <div class="semester-box">
                <div class="semester-title">1º Semestre</div>
                <ul class="courses-list">
                    <li class="course-row">
                        <span>Data Analytics</span>
                        <span class="course-credits">6 ECTS</span>
                    </li>
                    <li class="course-row">
                        <span>Big Data e Visualização</span>
                        <span class="course-credits">6 ECTS</span>
                    </li>
                    <li class="course-row">
                        <span>Estatística Aplicada</span>
                        <span class="course-credits">6 ECTS</span>
                    </li>
                    <li class="course-row">
                        <span>Modelação e Previsão</span>
                        <span class="course-credits">6 ECTS</span>
                    </li>
                    <li class="course-row">
                        <span>Projeto Final</span>
                        <span class="course-credits">6 ECTS</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
