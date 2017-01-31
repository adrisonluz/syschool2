@extends('layout/app')

@section('content')

<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-xs-6">
                    <p><strong>Emitido em: </strong>{{$contrato->emissao}}</p>
                </div>
            </div>

            <div class="box-body text-justify">
                <div class="col-xs-12">
                    <h1 class="text-center">CONTRATO DE PRESTAÇÃO DE SERVIÇOS</h1>
                    <br>
                    <p>Pelo presente instrumento particular de serviços, Escola de Dança Aline Rosa com sede nesta capital na Av. Assis Brasil 2100, 2° andar, bairro Passo D'Areia, Porto Alegre/RS, CNPJ 00714970/0001-59 neste ato representado por sua diretora abaixo firmado doravante denominada simplesmente <strong>CONTRATADO</strong>, e do outro lado, doravante denominado <strong>CONTRATANTE</strong> Sr(a) <strong>{{$data->usuario->nome}}</strong>, CPF <strong>{{$data->usuario->cpf}}</strong> residente no endereço <strong>{{$data->usuario->endereco}}</strong>, no bairro <strong>{{$data->usuario->bairro}}</strong> na cidade de <strong>{{$data->usuario->cidade}}/RS</strong> tem justo e contratado:</p>

                    <p><strong>Cláusula 1°:</strong> O presente contrato é estabelecido sob preceitos da Lei de Diretrizes e Bases da Educação e regimento dos cursos livre, tem por finalidade a prestação de serviços educacionais em Dança. O <strong>CONTRATADO</strong> colocará a disposição do <strong>CONTRATANTE</strong> aulas de <strong>{{$data->aulas}}</strong>no(os) dia(s) <strong>{{$data->horarios}}</strong> nas dependências da Escola de Dança Aline Rosa. A duração do presente contrato é de <strong>{{$data->meses}} meses</strong> a contar da data de assinatura do mesmo até dezembro do corrente ano.</p>

                    <p><strong>Cláusula 2°:</strong> O <strong>CONTRATANTE</strong> pagará ao <strong>CONTRATADO</strong> pelos serviços prestados o seguinte: taxa de matrícula no valor de <strong>R$ {{$data->matricula}}</strong> e mais <strong>{{$data->mensalidades}} mensalidades no valor de R$ {{$data->valor_mensalidade}}</strong>. O valor é antecipado no dia 10 de cada mês. Sendo a Escola da iniciativa privada as mensalidades são pagas integralmente do período de entrada a dezembro, sem descontos. A quantidade de aulas do ano letivo é de <strong>{{$data->total_aulas}} aulas</strong>. A mensalidade de dezembro deverá ser paga integralmente, pois a carga horária deste mês foi completada durante o ano letivo através de aulas extras, ensaios. <strong>No caso de inadimplência no período de dois meses o aluno não poderá frequentar as aulas até quitar as mensalidades pendentes.</strong></p>

                    <p><strong>Cláusula 3°:</strong> A cobrança de mensalidades será realizada através de boleto bancário fornecido pelo <strong>CONTRATADO</strong>. O <strong>CONTRATANTE</strong> deverá pagar custa dos encargos, juros e demais taxas em caso de atraso. Não será aceito pagamento na secretaria da Escola por motivo de segurança. A assiduidade as aulas é responsabilidade do <strong>CONTRATANTE</strong>. Em caso de falta a recuperação será realizada nos horários e turmas compatíveis que o <strong>CONTRATADO</strong> dispõe. Em caso de falta o aluno não haverá desconto na mensalidade. O material das aulas teóricas não está incluso na mensalidade sendo cobrado separadamente de acordo com o andamento do curso e o nível técnico dos alunos.</p>

                    <p><strong>Cláusula: 4</strong>°: O aluno que desistir no decorrer do ano letivo deverá assinar o termo de cancelamento na secretaria da Escola, estar com as mensalidades dos meses anteriores em dia para cancelar o presente contrato. Haverá uma taxa de R$ 60,00 para o cancelamento, pois as turmas têm números de vagas limitado. Caso não seja assinado o termo de cancelamento as mensalidades estarão correndo por conta do <strong>CONTRATANTE</strong> até o final do presente contrato, e sujeitos a cobrança judicial.</p>

                    <p><strong>Cláusula 5:</strong> O ingresso do estudante na Escola pressupõe que tenha condições de saúde para frequentar as aulas e realizar esforço físico, sendo de sua inteira responsabilidade informar a Escola eventuais lesões, uso contínuo de medicamentos, doenças ou sequelas de tratamentos realizados.</p>

                    <p><strong>Cláusulas 6:</strong> Passeios extras, amostras de arte, festivais de dança deverão ter a autorização por escrito e será responsabilidade dos pais o custeio dos mesmos quando menor de idade. Toda a atividade, ensaio, apresentação compõem a carga horária e são consideradas como aula dada.</p>

                    <p><strong>Cláusula 7:</strong> O <strong>CONTRATANTE</strong> reconhece a competência da Escola de Dança e aceita os programas de ensino adotados, atacando ao seu regimento interno, normas disciplinares, agrupamento de estudantes em turmas conforme nível técnico, como a inclusão – ou não – nas diversas danças, apresentações ocasionais ou festivais competitivos. Comprometendo-se oferecer aulas ministradas por profissionais qualificados, procurar contribuir para o desenvolvimento físico e intelectual do estudante; promover objetivamente o progresso técnico e artístico do estudante com suas aptidões e possibilidades individuais. O <strong>CONTRATADO</strong> se reserva o direito de mudanças técnicas e de professor ao seu critério. Os professores muito embora se comprometam a despender a todos os estudantes a mesma atenção e ensinamentos, não garantem os mesmos resultados e promoções iguais a todos. É do conhecimento do <strong>CONTRATANTE</strong> que as condições físicas são individuais e distintas, e que o tempo para atingir cada nível de progresso varia de aluno para aluno.</p>

                    <p><strong>Cláusula 8°:</strong> As apresentações realizadas pela Escola serão organizadas pela mesma, ficando aos pais ou responsável o compromisso de pagar o figurino e a taxa de participação para a inclusão do aluno na atividade. Será assinado um contrato especial para participação neste evento.</p>

                    <p><strong>Cláusula 9°:</strong> Todos são responsáveis pela conservação da Escola em todos os seus aspectos, devendo pagar os danos como fator de justiça, todo aquele que os causar. O aluno é responsável pelo seu material, mochila, bolsa, roupa, carteira, celular ou objetos de valor. A Escola dispõe de armários rotativos ou fixos para guardar os pertences com segurança.</p>

                    <p><strong>Cláusula 10°:</strong> O aluno, ou seus pais, caso seja menor de idade, desde já cedem a Escola o direito de imagem, autorizando a veiculação de sua imagem em todos os meios de publicação e difusão que interessem aos fins artísticos e/ou comerciais da Escola de Dança Aline Rosa como entidades voltadas a fins educacionais e culturais.</p>

                    <p><strong>Cláusula 11°:</strong> O <strong>CONTRATADO</strong> deverá comunicar ao <strong>CONTRATANTE</strong> toda e qualquer modificação técnica ou atividade realizada na Escola. Todas as informações que constam na ficha de cadastro são de responsabilidade do <strong>CONTRATANTE</strong>. Em caso de alteração nos dados, deve o <strong>CONTRATANTE</strong> informar a secretaria da Escola para evitar falhas na comunicação.</p>

                    <p><strong>Cláusula 12°:</strong> Fica claramente entendido que tanto os serviços que o <strong>CONTRATADO</strong> presta, bem como o presente contrato, não serão em nenhum momento considerados experimentais.</p>

                    <p>Assim por estarem justas e contratadas, as partes assinam o presente em duas vias de igual teor e forma.</p>
                </div>

                <div class="col-xs-6 text-center">
                    <hr>
                    <p><strong>CONTRATADO</strong></p>
                </div>

                <div class="col-xs-6 text-center">
                    <hr>
                    <p><strong>CONTRATANTE</strong></p>
                </div>

                <div class="col-xs-12">&nbsp;</div>

                <div class="col-xs-6 text-right off-set-6 pull-right">
                    <p>Porto Alegre, _____ de _________________ de 2017.</p>
                </div>
            </div>

            <div class="box-footer">
                <a href="{{ url('contratos/imprimir/' . $contrato->id) }}" class="btn btn-success pull-right" title="Imprimir" alt="Imprimir">Imprimir</a>
            </div>
        </div>
    </div>
</div>

@endsection
