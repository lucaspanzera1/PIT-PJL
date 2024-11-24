    // Função para aplicar a máscara ao CEP
    function maskCEP(input) {
        let value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        value = value.replace(/^(\d{5})(\d)/, '$1-$2'); // Adiciona o hífen após os primeiros 5 dígitos
        input.value = value;
    }

    // Função para garantir que o CEP esteja no formato correto
    function formatCEP(value) {
        value = value.replace(/\D/g, ''); // Remove caracteres não numéricos
        return value.replace(/^(\d{5})(\d{3})$/, '$1-$2'); // Formata como 00000-000
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.getElementById('cep');
        const form = document.getElementById('registerForm');
        
        // Aplica a máscara enquanto o usuário digita
        cepInput.addEventListener('input', function() {
            maskCEP(this);
        });

        // Garante que o CEP esteja formatado corretamente antes de enviar o formulário
        form.addEventListener('submit', function(event) {
            cepInput.value = formatCEP(cepInput.value);
        });

        // Validação do CEP
        cepInput.addEventListener('blur', function() {
            var cep = this.value.replace(/\D/g, '');
            if (cep.length != 8) {
                document.getElementById('cepError').style.display = 'block';
                return;
            }

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        document.getElementById('cepError').style.display = 'block';
                        return;
                    }

                    if (data.localidade !== 'Belo Horizonte' && data.localidade !== 'Contagem') {
                        document.getElementById('cepError').style.display = 'block';
                        return;
                    }

                    document.getElementById('cepError').style.display = 'none';
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('regiao').value = mapearRegiaoBH(data.bairro);
                    this.value = formatCEP(cep); // Garante que o CEP esteja formatado após a validação
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById('cepError').style.display = 'block';
                });
        });

        function mapearRegiaoBH(bairro) {
  const regioesBH = {
    'Centro-Sul': [
      'Acaba Mundo', 'Anchieta', 'Ápia', 'Barro Preto', 'Belvedere', 'Boa Viagem',
      'Carmo', 'Centro', 'Cidade Jardim', 'Comiteco', 'Coração de Jesus',
      'Cruzeiro', 'Estrela', 'Fazendinha', 'Funcionários', 'Lourdes', 'Luxemburgo',
      'Mangabeiras', 'Marçola', 'Monte São José', 'Nossa Senhora da Aparecida',
      'Nossa Senhora da Conceição', 'Nossa Senhora de Fátima', 'Nossa Senhora do Rosário',
      'Novo São Lucas', 'Pindura Saia', 'Santa Efigênia', 'Santa Isabel',
      'Santa Lúcia', 'Santa Rita de Cássia', 'Santana do Cafezal', 'Santo Agostinho',
      'Santo Antônio', 'São Bento', 'São Lucas', 'São Pedro', 'Savassi', 'Serra',
      'Sion', 'Vila Bandeirantes', 'Vila Barragem Santa Lúcia', 'Vila Fumec',
      'Vila Novo São Lucas', 'Vila Paris'
    ],
    'Leste': [
      'Alto Vera Cruz', 'Baleia', 'Belém', 'Boa Vista', 'Caetano Furquim',
      'Camponesa I', 'Camponesa III', 'Casa Branca', 'Cidade Jardim Taquaril',
      'Cônego Pinheiro', 'Cônego Pinheiro A', 'Esplanada', 'Granja de Freitas',
      'Grota', 'Horto', 'Horto Florestal', 'João Alfredo', 'Jonas Veiga',
      'Mariano de Abreu', 'Nova Vista', 'Paraíso', 'Pirineus', 'Pompéia',
      'Sagrada Família', 'Santa Inês', 'Santa Tereza', 'São Geraldo',
      'São Vicente', 'Taquaril', 'Vera Cruz', 'Vila Boa Vista', 'Vila da Área',
      'Vila Dias', 'Vila Nossa Senhora do Rosário', 'Vila Paraíso', 'Vila São Geraldo',
      'Vila São Rafael', 'Vila União', 'Vila Vera Cruz I', 'Vila Vera Cruz II'
    ],
    'Nordeste': [
      'Acaiaca', 'Andiroba', 'Antônio Ribeiro de Abreu', 'Beija Flor',
      'Beira-Linha', 'Belmonte', 'Boa Esperança', 'Cachoeirinha', 'Canadá',
      'Capitão Eduardo', 'Cidade Nova', 'Dom Joaquim', 'Dom Silvério', 'Eymard',
      'Fernão Dias', 'Goiânia', 'Graça', 'Grotinha', 'Guanabara', 'Ipê',
      'Ipiranga', 'Maria Goretti', 'Maria Virgínia', 'Nazaré', 'Nova Floresta',
      'Ouro Minas', 'Paulo VI', 'Penha', 'Pirajá', 'Ribeiro de Abreu',
      'São Benedito', 'São Gabriel', 'São Marcos', 'São Paulo', 'São Sebastião',
      'Silveira', 'Tiradentes', 'Três Marias', 'União', 'Vila da Luz',
      'Vila da Paz', 'Vila de Sá', 'Vila do Pombal', 'Vila Inestan',
      'Vila Ipiranga', 'Vila Maria', 'Vila Nova Cachoeirinha IV', 'Vila Ouro Minas',
      'Vila São Dimas', 'Vila São Gabriel', 'Vila São Gabriel Jacuí',
      'Vila São Paulo', 'Vista do Sol', 'Vitória'
    ],
    'Noroeste': [
      'Alto Caiçaras', 'Alto dos Pinheiros', 'Aparecida', 'Aparecida Sétima Seção',
      'Bom Jesus', 'Caiçara-Adelaide', 'Caiçaras', 'Califórnia', 'Carlos Prates',
      'Coração Eucarístico', 'Dom Bosco', 'Dom Cabral', 'Glória', 'Jardim Montanhês',
      'João Pinheiro', 'Lorena', 'Marmiteiros', 'Minas Brasil', 'Nova Cachoeirinha',
      'Nova Esperança', 'Novo Glória', 'Padre Eustáquio', 'Pedreira Prado Lopes',
      'Pindorama', 'São Cristóvão', 'São Francisco das Chagas', 'São Salvador',
      'Senhor dos Passos', 'Sumaré', 'Vila Califórnia', 'Vila Coqueiral',
      'Vila das Oliveiras', 'Vila Maloca', 'Vila Nova Cachoeirinha I',
      'Vila Nova Cachoeirinha II', 'Vila PUC', 'Vila Sumaré',
      'Vila Trinta e Um de Março'
    ],
    'Norte': [
      'Aarão Reis', 'Bacurau', 'Biquinhas', 'Boa União I', 'Boa União II',
      'Campo Alegre', 'Conjunto Floramar', 'Conjunto Providência', 'Etelvina Carneiro',
      'Floramar', 'Frei Leopoldo', 'Granja Werneck', 'Guarani', 'Heliópolis',
      'Jaqueline', 'Jardim Felicidade', 'Juliana', 'Lajedo', 'Madri',
      'Maria Teresa', 'Mariquinhas', 'Minaslândia', 'Mirante', 'Monte Azul',
      'Novo Aarão Reis', 'Novo Tupi', 'Planalto', 'Primeiro de Maio', 'Providência',
      'São Bernardo', 'São Gonçalo', 'São Tomáz', 'Solimões', 'Tupi A', 'Tupi B',
      'Vila Aeroporto', 'Vila Clóris', 'Vila Minaslândia', 'Vila Nova',
      'Vila Primeiro de Maio', 'Xodó-Marize', 'Zilah Spósito'
    ],
    'Oeste': [
      'Alpes', 'Alto Barroca', 'Ambrosina', 'Bairro das Indústrias II',
      'Barão Homem de Melo I', 'Barão Homem de Melo III', 'Barão Homem de Melo IV',
      'Barroca', 'Betânia', 'Buritis', 'Cabana do Pai Tomás', 'Calafate',
      'Camargos', 'Chácara Leonina', 'Cinqüentenário', 'Custodinha', 'Estoril',
      'Estrela do Oriente', 'Gameleira', 'Grajaú', 'Guaratã', 'Gutierrez',
      'Havaí', 'Imbaúbas', 'Jardinópolis', 'Leonina', 'Madre Gertrudes',
      'Marajó', 'Maravilha', 'Nova Cintra', 'Nova Gameleira', 'Nova Granada',
      'Nova Suissa', 'Oeste', 'Palmeiras', 'Pantanal', 'Parque São José',
      'Prado', 'Salgado Filho', 'Santa Maria', 'Santa Sofia', 'São Jorge I',
      'São Jorge II', 'São Jorge III', 'Sport Club', 'Ventosa', 'Vila Antena',
      'Vila Betânia', 'Vila Calafate', 'Vila da Amizade', 'Vila Havaí',
      'Vila Madre Gertrudes I', 'Vila Madre Gertrudes II', 'Vila Madre Gertrudes III',
      'Vila Madre Gertrudes V', 'Vila Nova Gameleira I', 'Vila Nova Gameleira II',
      'Vila Nova Gameleira III', 'Vila Nova Paraíso', 'Vila Oeste',
      'Vila Vista Alegre', 'Virgínia', 'Vista Alegre'
    ],
    'Pampulha': [
      'Aeroporto', 'Alípio de Melo', 'Bandeirantes', 'Bispo de Maura',
      'Braúnas', 'Campus Ufmg', 'Castelo', 'Confisco', 'Conjunto Celso Machado',
      'Conjunto Lagoa', 'Conjunto São Francisco de Assis', 'Dona Clara',
      'Engenho Nogueira', 'Garças', 'Indaiá', 'Itapoã', 'Itatiaia', 'Jaraguá',
      'Jardim Alvorada', 'Jardim Atlântico', 'Jardim São José', 'Liberdade',
      'Manacás', 'Nova Pampulha', 'Novo Ouro Preto', 'Ouro Preto', 'Paquetá',
      'Santa Amélia', 'Santa Branca', 'Santa Rosa', 'Santa Terezinha',
      'São Francisco', 'São José', 'São Luíz', 'Serrano', 'Suzana', 'Trevo',
      'Universitário', 'Urca', 'Vila Aeroporto Jaraguá', 'Vila Antena Montanhês',
      'Vila Engenho Nogueira', 'Vila Jardim Alvorada', 'Vila Jardim Montanhês',
      'Vila Jardim São José', 'Vila Paquetá', 'Vila Real I', 'Vila Real II',
      'Vila Rica', 'Vila Santa Rosa', 'Vila Santo Antônio',
      'Vila Santo Antônio Barroquinha', 'Vila São Francisco', 'Vila Suzana I',
      'Vila Suzana II', 'Xangri-Lá'
    ],
    'Venda Nova': [
      'Apolônia', 'Canaã', 'Candelária', 'Cenáculo', 'Céu Azul', 'Copacabana',
      'Europa', 'Flamengo', 'Jardim dos Comerciários', 'Jardim Leblon', 'Lagoa',
      'Lagoinha Leblon', 'Laranjeiras', 'Letícia', 'Mantiqueira', 'Maria Helena',
      'Minascaixa', 'Nova América', 'Parque São Pedro', 'Piratininga',
      'Rio Branco', 'Santa Mônica', 'São Damião', 'São João Batista',
      'Serra Verde', 'Unidas', 'Universo', 'Várzea da Palma', 'Venda Nova',
      'Vila Canto do Sabiá', 'Vila Copacabana', 'Vila dos Anjos',
      'Vila Jardim Leblon', 'Vila Mantiqueira', 'Vila Nossa Senhora Aparecida',
      'Vila Piratininga Venda Nova', 'Vila Santa Mônica', 'Vila São João Batista',
      'Vila Satélite', 'Vila Sesc'
    ],
    'Barreiro': [
      'Ademar Maldonado', 'Águas Claras', 'Alta Tensão', 'Alta Tensão I',
      'Alto das Antenas', 'Araguaia', 'Átila de Paiva', 'Bairro das Indústrias I',
      'Bairro Novo das Indústrias', 'Barreiro', 'Bernadete', 'Bonsucesso',
      'Brasil Industrial', 'Cardoso', 'Castanheira', 'CDI Jatobá',
      'Conjunto Bonsucesso', 'Conjunto Jatobá', 'Corumbiara', 'Diamante',
      'Distrito Industrial do Jatobá', 'Ernesto do Nascimento', 'Esperança',
      'Flávio de Oliveira', 'Flávio Marques Lisboa', 'Independência',
      'Itaipu', 'Jardim do Vale', 'Jatobá', 'João Paulo II', 'Lindéia',
      'Mangueiras', 'Marieta I', 'Marieta II', 'Marilândia', 'Milionários',
      'Mineirão', 'Miramar', 'Novo Santa Cecília', 'Olaria', 'Petrópolis',
      'Pilar', 'Pongelupe', 'Santa Cecília', 'Santa Helena', 'Santa Margarida',
      'Santa Rita', 'Serra do Curral', 'Solar do Barreiro', 'Teixeira Dias',
      'Tirol', 'Túnel de Ibirité', 'Vale do Jatobá', 'Vila Átila de Paiva',
      'Vila Batik', 'Vila Cemig', 'Vila Copasa', 'Vila Ecológica', 'Vila Formosa',
      'Vila Independência I', 'Vila Independência II', 'Vila Independência IV',
      'Vila Mangueiras', 'Vila Nova dos Milionários', 'Vila Olhos d\'Água',
      'Vila Petrópolis', 'Vila Pilar', 'Vila Pinho', 'Vila Piratininga',
      'Vila Santa Rita', 'Vila Tirol', 'Vitória da Conquista'
    ]
  };

  for (const regiao in regioesBH) {
    if (regioesBH[regiao].includes(bairro)) {
      return regiao;
    }
  }
  
  return 'Região não identificada';
}
    });