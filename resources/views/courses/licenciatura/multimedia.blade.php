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
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 2rem;
        }

        .semester-box {
            flex: 1 1 calc(50% - 2rem);
            max-width: calc(50% - 2rem);
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

    <div class="course-banner"
        style="background-image: url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="course-banner-content">
            <h1>Engenharia de Multimédia</h1>
            <p>Criação, desenvolvimento e integração de conteúdos digitais interativos e multimodais</p>
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
                                <p>Licenciatura (3 Anos / 6 semestres)</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h3>Duração</h3>
                                <p>3 anos (180 ECTS)</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <h3>Regime</h3>
                                <p>Diurno | Pós-laboral</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h3>Localização</h3>
                                <p>Porto</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <div>
                                <h3>Propina Mensal</h3>
                                <p>220€</p>
                            </div>
                        </div>
                    </div>

                    <div class="course-info-card">
                        <h3 style="color: var(--primary-color); margin-top: 0;">Áreas de Atuação</h3>
                        <ul>
                            <li>Design de Interação</li>
                            <li>Produção de Vídeo e Áudio</li>
                            <li>Desenvolvimento Web e Mobile</li>
                            <li>Realidade Virtual e Aumentada</li>
                            <li>Experiência do Utilizador (UX/UI)</li>
                        </ul>
                    </div>
                </div>

                <div class="course-description">
                    <p>O curso de Engenharia de Multimédia do ISTP oferece uma formação sólida em tecnologias digitais
                        interativas, combinando design, programação e produção de conteúdos multimédia.</p>

                    <h3>Objetivos do Curso</h3>
                    <p>Formar profissionais capazes de:</p>
                    <ul>
                        <li>Conceber experiências digitais inovadoras</li>
                        <li>Integrar som, imagem, vídeo e programação</li>
                        <li>Projetar interfaces interativas</li>
                        <li>Desenvolver aplicações multimédia para web e mobile</li>
                        <li>Trabalhar em equipas criativas e tecnológicas</li>
                    </ul>

                    <h3>Diferenciais</h3>
                    <ul>
                        <li>Estúdios de áudio e vídeo de última geração</li>
                        <li>Projetos interdisciplinares com empresas reais</li>
                        <li>Corpo docente com experiência na indústria criativa</li>
                        <li>Enfoque prático e inovador</li>
                        <li>Estágios e parcerias com empresas do setor</li>
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
                    <div class="semester-title">1.º Ano – 1º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Fundamentos de Multimédia</span><span class="course-credits">6
                                ECTS</span></li>
                        <li class="course-row"><span>Design Gráfico Digital</span><span class="course-credits">6 ECTS</span>
                        </li>
                        <li class="course-row"><span>Programação Web I</span><span class="course-credits">6 ECTS</span></li>
                        <li class="course-row"><span>Fotografia Digital</span><span class="course-credits">6 ECTS</span>
                        </li>
                    </ul>
                </div>
                <div class="semester-box">
                    <div class="semester-title">1.º Ano – 2º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Produção de Vídeo</span><span class="course-credits">6 ECTS</span></li>
                        <li class="course-row"><span>UX/UI Design</span><span class="course-credits">6 ECTS</span></li>
                        <li class="course-row"><span>Programação Web II</span><span class="course-credits">6 ECTS</span>
                        </li>
                        <li class="course-row"><span>Comunicação Visual</span><span class="course-credits">6 ECTS</span>
                        </li>
                    </ul>
                </div>
                <div class="semester-box">
                    <div class="semester-title">2.º Ano – 3º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Modelação 3D</span><span class="course-credits">6 ECTS</span></li>
                        <li class="course-row"><span>Animação Digital</span><span class="course-credits">6 ECTS</span></li>
                        <li class="course-row"><span>Interação Humano-Computador</span><span class="course-credits">6
                                ECTS</span></li>
                        <li class="course-row"><span>Design de Som</span><span class="course-credits">6 ECTS</span></li>
                    </ul>
                </div>
                <div class="semester-box">
                    <div class="semester-title">2.º Ano – 4º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Realidade Virtual e Aumentada</span><span class="course-credits">6
                                ECTS</span></li>
                        <li class="course-row"><span>Desenvolvimento de Jogos</span><span class="course-credits">6
                                ECTS</span></li>
                        <li class="course-row"><span>Gestão de Projetos Multimédia</span><span class="course-credits">6
                                ECTS</span></li>
                        <li class="course-row"><span>Motion Graphics</span><span class="course-credits">6 ECTS</span></li>
                    </ul>
                </div>
                <div class="semester-box">
                    <div class="semester-title">3.º Ano – 5º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Laboratório Multimédia</span><span class="course-credits">8 ECTS</span>
                        </li>
                        <li class="course-row"><span>Marketing Digital</span><span class="course-credits">4 ECTS</span></li>
                        <li class="course-row"><span>Design de Interfaces</span><span class="course-credits">6 ECTS</span>
                        </li>
                        <li class="course-row"><span>Inovação e Criatividade</span><span class="course-credits">6
                                ECTS</span></li>
                    </ul>
                </div>
                <div class="semester-box">
                    <div class="semester-title">3.º Ano – 6º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Estágio/Projeto Final</span><span class="course-credits">12 ECTS</span>
                        </li>
                        <li class="course-row"><span>Empreendedorismo Digital</span><span class="course-credits">6
                                ECTS</span></li>
                        <li class="course-row"><span>Temas Emergentes em Multimédia</span><span class="course-credits">6
                                ECTS</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
