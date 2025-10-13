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
        style="background-image: url('https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1350&q=80');">
        <div class="course-banner-content">
            <h1>Desenvolvimento Mobile (CTeSP)</h1>
            <p>Formação prática no desenvolvimento de aplicações móveis para diferentes plataformas e dispositivos</p>
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
                                <p>CTeSP (2 anos / 4 semestres)</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h3>Duração</h3>
                                <p>2 anos (120 ECTS)</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <h3>Regime</h3>
                                <p>Pós‑laboral</p>
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
                                <p>220 € </p>
                            </div>
                        </div>
                    </div>
                    <div class="course-info-card">
                        <h3 style="color: var(--primary-color); margin-top: 0;">Perfil Profissional</h3>
                        <ul>
                            <li>Desenvolver aplicações móveis para múltiplas plataformas</li>
                            <li>Integrar APIs e serviços externos</li>
                            <li>Garantir a usabilidade e desempenho das apps</li>
                            <li>Testar, depurar e publicar aplicações</li>
                            <li>Manter e atualizar apps conforme necessidades do mercado</li>
                            <li>Trabalhar com metodologias ágeis</li>
                            <li>Colaborar com equipas de design e backend</li>
                        </ul>
                    </div>
                </div>
                <div class="course-description">
                    <p>O CTeSP em Desenvolvimento Mobile forma técnicos superiores profissionais especializados no
                        desenvolvimento, teste e manutenção de aplicações móveis para várias plataformas, assegurando
                        usabilidade, desempenho e integração com serviços externos.</p>

                    <h3>Objetivos do Curso</h3>
                    <p>Capacitar os alunos para:</p>
                    <ul>
                        <li>Desenvolver aplicações móveis para múltiplas plataformas</li>
                        <li>Implementar interfaces intuitivas e responsivas</li>
                        <li>Gerir ciclos de vida e manutenção de apps</li>
                        <li>Integrar APIs e serviços web</li>
                        <li>Assegurar desempenho e segurança das aplicações</li>
                        <li>Testar e otimizar aplicações móveis</li>
                    </ul>
                    <h3>Diferenciais</h3>
                    <ul>
                        <li>Ambientes de desenvolvimento atualizados</li>
                        <li>Projetos práticos e desenvolvimento colaborativo</li>
                        <li>Estágio em empresas tecnológicas</li>
                        <li>Acompanhamento técnico especializado</li>
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
                    <div class="semester-title">1.º Ano – 1.º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Sistemas de Gestão de Conteúdos</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Matemática</span><span class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Fundamentos de Desenvolvimento de Software</span><span
                                class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Introdução à Programação</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Bases de Dados SQL</span><span class="course-credits">3 ECTS</span>
                        </li>
                        <li class="course-row"><span>Administração de Sistemas</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Algoritmos e Estruturas de Dados</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Conceção de Interfaces Gráficas</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Desenvolvimento Ágil de Software</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Introdução às Redes de Dados</span><span class="course-credits">3
                                ECTS</span></li>
                    </ul>
                </div>
                <div class="semester-box">
                    <div class="semester-title">1.º Ano – 2.º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Língua Portuguesa</span><span class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Gestão de Projetos</span><span class="course-credits">3 ECTS</span>
                        </li>
                        <li class="course-row"><span>Programação</span><span class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Programação Web‑Cliente</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Programação de Serviços Web</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Programação Web‑Servidor</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Programação de Dispositivos Móveis</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Língua Inglesa</span><span class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Projeto de Aplicações Móveis</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Bases de Dados NoSQL</span><span class="course-credits">3 ECTS</span>
                        </li>
                    </ul>
                </div>
                <div class="semester-box">
                    <div class="semester-title">2.º Ano – 1.º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Cibersegurança</span><span class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Computação Móvel</span><span class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Internet das Coisas</span><span class="course-credits">3 ECTS</span>
                        </li>
                        <li class="course-row"><span>Modelação de Sistemas de Software</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Programação Web Avançada (Front‑end)</span><span
                                class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Projeto de Aplicações Web Avançadas</span><span
                                class="course-credits">3 ECTS</span></li>
                        <li class="course-row"><span>Publicação e Administração Web</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Testes e Qualidade de Software</span><span class="course-credits">3
                                ECTS</span></li>
                        <li class="course-row"><span>Projeto Final</span><span class="course-credits">6 ECTS</span></li>
                    </ul>
                </div>
                <div class="semester-box">
                    <div class="semester-title">2.º Ano – 2.º Semestre</div>
                    <ul class="courses-list">
                        <li class="course-row"><span>Formação em Contexto de Trabalho (FCT)</span><span
                                class="course-credits">30 ECTS</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
