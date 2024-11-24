        
        // Função para carregar conversas
        function carregarConversas() {
            fetch('../../api/get_conversas.php')
                .then(response => response.json())
                .then(conversas => {
                    const listaConversas = document.getElementById('conversas-lista');
                    listaConversas.innerHTML = '';
                    
                    conversas.forEach(conversa => {
                        const div = document.createElement('div');
                        div.className = `conversa-item ${conversa.id == destinatarioAtualId ? 'conversa-ativa' : ''}`;
                        div.onclick = () => selecionarConversa(conversa.id);
                        
                        const dataFormatada = new Date(conversa.data_ultima_mensagem).toLocaleString();
                        
                        div.innerHTML = `
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="${'../' + (conversa.imagem_perfil || 'upload/user_pfp/default.jpg')}"
                                     alt="${conversa.imagem_perfil}" 
                                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                <div>
                                    <strong>${conversa.nome}</strong>
                                    <p style="margin: 5px 0; color: #666;">${conversa.ultima_mensagem || 'Nenhuma mensagem'}</p>
                                    <small style="color: #999;">${dataFormatada}</small>
                                </div>
                                ${conversa.nao_lidas > 0 ? 
                                    `<span style="background: #1976d2; color: white; padding: 2px 6px; border-radius: 10px; margin-left: auto;">
                                        ${conversa.nao_lidas}
                                    </span>` : 
                                    ''}
                            </div>
                        `;
                        listaConversas.appendChild(div);
                    });
                })
                .catch(error => console.error('Erro ao carregar conversas:', error));
        }
        
        // Função para carregar mensagens
        function carregarMensagens(destinatarioId) {
    if (!destinatarioId) return;
    
    fetch(`../../api/get_mensagens.php?destinatario_id=${destinatarioId}`)
        .then(response => response.json())
        .then(mensagens => {
            const containerMensagens = document.getElementById('mensagens-container');
            const scrollPos = containerMensagens.scrollTop;
            const isScrolledToBottom = containerMensagens.scrollHeight - containerMensagens.scrollTop === containerMensagens.clientHeight;
            
            containerMensagens.innerHTML = '';
            
            if (mensagens && mensagens.length > 0) {
                mensagens.forEach(msg => {
                    const div = document.createElement('div');
                    div.className = `mensagem ${msg.remetente_id == usuarioId ? 'mensagem-enviada' : 'mensagem-recebida'}`;
                    
                    let conteudoMensagem = '';
                    if (msg.tipo_midia === 'imagem') {
                        conteudoMensagem = `
                            <img src="../../upload/chat/${msg.arquivo}" 
                                 class="chat-media" 
                                 onclick="abrirModal(this.src, 'imagem')"
                                 style="max-width: 200px; border-radius: 8px; cursor: pointer;">
                        `;
                    } else if (msg.tipo_midia === 'video') {
                        conteudoMensagem = `
                            <video src="../../upload/chat/${msg.arquivo}" 
                                   class="chat-media" 
                                   onclick="abrirModal('../../upload/chat/${msg.arquivo}', 'video')"
                                   controls
                                   style="max-width: 200px; border-radius: 8px; cursor: pointer;">
                            </video>
                        `;
                    } else {
                        conteudoMensagem = `<p style="margin: 5px 0;">${msg.mensagem || ''}</p>`;
                    }
                    
                    div.innerHTML = `
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                            <img src="${'../' + (msg.imagem_perfil || 'upload/user_pfp/default.jpg')}"
                                 alt="${msg.remetente_nome || 'Usuário'}" 
                                 style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                            <strong>${msg.remetente_nome || 'Usuário'}</strong>
                        </div>
                        ${conteudoMensagem}
                        <small style="color: #999;">${new Date(msg.data_envio).toLocaleString()}</small>
                    `;
                    
                    containerMensagens.appendChild(div);
                });

                // Marcar mensagens como lidas após carregá-las
                marcarMensagensComoLidas(destinatarioId);
                
                // Rolar para o final se estava no final antes
                if (isScrolledToBottom) {
                    containerMensagens.scrollTop = containerMensagens.scrollHeight;
                } else {
                    containerMensagens.scrollTop = scrollPos;
                }
            }
            
            // Debug para ver o conteúdo das mensagens
            console.log('Mensagens carregadas:', mensagens);
        })
        .catch(error => {
            console.error('Erro ao carregar mensagens:', error);
        });
}

function marcarMensagensComoLidas(destinatarioId) {
    if (!destinatarioId) return;

    // Debug para verificar a chamada
    console.log('Marcando mensagens como lidas para destinatário:', destinatarioId);

    const formData = new FormData();
    formData.append('destinatario_id', destinatarioId);

    fetch('../../api/marcar_como_lida.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            console.log('Mensagens marcadas como lidas com sucesso');
            carregarConversas(); // Atualiza a lista de conversas
        } else {
            console.error('Erro ao marcar mensagens como lidas:', result.message);
        }
    })
    .catch(error => {
        console.error('Erro ao marcar mensagens como lidas:', error);
    });
}

// Inicialização e eventos
document.addEventListener('DOMContentLoaded', function() {
    // Carregar mensagens iniciais se houver destinatário
    if (destinatarioAtualId) {
        carregarMensagens(destinatarioAtualId);
    }
    
    // Carregar conversas
    carregarConversas();
    
    // Atualizar periodicamente
    setInterval(() => {
        carregarConversas();
        if (destinatarioAtualId) {
            carregarMensagens(destinatarioAtualId);
        }
    }, 500);
});
        // Função para selecionar conversa
        function selecionarConversa(destinatarioId) {
            destinatarioAtualId = destinatarioId;
            document.querySelectorAll('.conversa-item').forEach(item => item.classList.remove('conversa-ativa'));
            event.currentTarget.classList.add('conversa-ativa');
            carregarMensagens(destinatarioId);
            
            // Atualizar URL sem recarregar a página
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set('destinatario', destinatarioId);
            window.history.pushState({}, '', newUrl);
        }
        
        // Enviar mensagem
        document.getElementById('form-mensagem').onsubmit = function(e) {
            e.preventDefault();
            if (!destinatarioAtualId) {
                alert('Por favor, selecione um destinatário primeiro.');
                return;
            }
            
            const input = document.getElementById('mensagem-input');
            const mensagem = input.value.trim();
            if (!mensagem) return;
            
            fetch('../../api/enviar_mensagem.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    destinatario_id: destinatarioAtualId,
                    mensagem: mensagem
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    input.value = '';
                    carregarMensagens(destinatarioAtualId);
                    carregarConversas();
                } else {
                    alert('Erro ao enviar mensagem. Por favor, tente novamente.');
                }
            })
            .catch(error => {
                console.error('Erro ao enviar mensagem:', error);
                alert('Erro ao enviar mensagem. Por favor, tente novamente.');
            });
        };
        
        // Inicialização
        if (destinatarioAtualId) {
            carregarMensagens(destinatarioAtualId);
        }
        carregarConversas();
        
        // Atualizar conversas e mensagens periodicamente
        setInterval(carregarConversas, 10000);
        setInterval(() => {
            if (destinatarioAtualId) {
                carregarMensagens(destinatarioAtualId);
            }
        }, 3000);

        let selectedFiles = [];
        
        document.getElementById('media-input').onchange = function(e) {
            const files = Array.from(e.target.files);
            selectedFiles = selectedFiles.concat(files);
            
            const previewContainer = document.getElementById('media-preview-container');
            
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'media-preview-wrapper';
                    
                    if (file.type.startsWith('image/')) {
                        preview.innerHTML = `
                            <img src="${e.target.result}" class="media-preview">
                            <button onclick="removeFile('${file.name}')">&times;</button>
                        `;
                    } else if (file.type.startsWith('video/')) {
                        preview.innerHTML = `
                            <video src="${e.target.result}" class="media-preview"></video>
                            <button onclick="removeFile('${file.name}')">&times;</button>
                        `;
                    }
                    
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });
        };
        
        function removeFile(fileName) {
            selectedFiles = selectedFiles.filter(file => file.name !== fileName);
            refreshPreview();
        }
        
        function refreshPreview() {
            const previewContainer = document.getElementById('media-preview-container');
            previewContainer.innerHTML = '';
            selectedFiles.forEach(file => {
                // ... repetir lógica de preview ...
            });
        }
        
        // Atualizar a função de renderizar mensagens
        function renderizarMensagem(msg) {
            const div = document.createElement('div');
            div.className = `mensagem ${msg.remetente_id == usuarioId ? 'mensagem-enviada' : 'mensagem-recebida'}`;
            
            let conteudoMensagem = '';
            
            if (msg.tipo_midia === 'imagem') {
                conteudoMensagem = `
                    <img src="../upload/chat/${msg.arquivo}" 
                         class="chat-media" 
                         onclick="abrirModal(this.src, 'imagem')">
                `;
            } else if (msg.tipo_midia === 'video') {
                conteudoMensagem = `
                    <video src="../upload/chat/${msg.arquivo}" 
                           class="chat-media" 
                           controls
                           onclick="abrirModal(this.src, 'video')"></video>
                `;
            } else {
                conteudoMensagem = `<p style="margin: 5px 0;">${msg.mensagem}</p>`;
            }
            
            div.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                    <img src="${'../' + (msg.imagem_perfil || 'upload/user_pfp/default.jpg')}"
                         alt="${msg.remetente_nome}" 
                         style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                    <strong>${msg.remetente_nome}</strong>
                </div>
                ${conteudoMensagem}
                <small style="color: #999;">${new Date(msg.data_envio).toLocaleString()}</small>
            `;
            
            return div;
        }
        
        function abrirModal(src, tipo) {
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    `;
    
    const conteudoWrapper = document.createElement('div');
    conteudoWrapper.style.cssText = `
        max-width: 90%;
        max-height: 90vh;
        position: relative;
    `;
    
    if (tipo === 'imagem') {
        conteudoWrapper.innerHTML = `<img src="${src}" style="max-width: 100%; max-height: 90vh; object-fit: contain;">`;
    } else if (tipo === 'video') {
        // Remove autoplay e adiciona um thumbnail/play button
        conteudoWrapper.innerHTML = `
            <div style="position: relative; display: inline-block;">
                <video src="${src}" 
                       controls 
                       style="max-width: 100%; max-height: 90vh;">
                </video>
                <div class="play-button" 
                     style="position: absolute; 
                            top: 50%; 
                            left: 50%; 
                            transform: translate(-50%, -50%); 
                            background: rgba(0,0,0,0.7); 
                            border-radius: 50%; 
                            width: 60px; 
                            height: 60px; 
                            display: flex; 
                            align-items: center; 
                            justify-content: center; 
                            cursor: pointer;
                            transition: background 0.3s;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>
            </div>
        `;

        // Adiciona os eventos de controle do vídeo
        const video = conteudoWrapper.querySelector('video');
        const playButton = conteudoWrapper.querySelector('.play-button');
        
        // Mostra/esconde o botão de play baseado no estado do vídeo
        video.addEventListener('play', () => {
            playButton.style.display = 'none';
        });
        
        video.addEventListener('pause', () => {
            playButton.style.display = 'flex';
        });
        
        video.addEventListener('ended', () => {
            playButton.style.display = 'flex';
        });
        
        // Adiciona o evento de clique no botão de play
        playButton.onclick = (e) => {
            e.stopPropagation();
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        };
        
        // Previne que o clique no vídeo feche o modal
        video.onclick = (e) => e.stopPropagation();
    }
    
    modal.appendChild(conteudoWrapper);
    
    // Fecha o modal quando clicar fora do conteúdo
    modal.onclick = () => modal.remove();
    
    document.body.appendChild(modal);
}
        
        // Atualizar o envio do formulário
        document.getElementById('form-mensagem').onsubmit = function(e) {
            e.preventDefault();
            if (!destinatarioAtualId) {
                alert('Por favor, selecione um destinatário primeiro.');
                return;
            }
            
            const input = document.getElementById('mensagem-input');
            const mensagem = input.value.trim();
            
            const formData = new FormData();
            formData.append('destinatario_id', destinatarioAtualId);
            formData.append('mensagem', mensagem);
            
            selectedFiles.forEach(file => {
                formData.append('arquivos[]', file);
            });
            
            fetch('../../api/enviar_mensagem.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    input.value = '';
                    selectedFiles = [];
                    document.getElementById('media-preview-container').innerHTML = '';
                    carregarMensagens(destinatarioAtualId);
                    carregarConversas();
                } else {
                    alert('Erro ao enviar mensagem. Por favor, tente novamente.');
                }
            })
            .catch(error => {
                console.error('Erro ao enviar mensagem:', error);
                alert('Erro ao enviar mensagem. Por favor, tente novamente.');
            });
        };
        function preencherMensagem(texto) {
            const input = document.getElementById('mensagem-input');
            input.value = texto;
            input.focus();
        }

        // Adicionar estilo hover para os botões
        document.querySelectorAll('.preset-btn').forEach(btn => {
            btn.addEventListener('mouseover', () => {
                btn.style.background = '#e4e6eb';
            });
            btn.addEventListener('mouseout', () => {
                btn.style.background = '#f0f2f5';
            });
        });

        const togglePresetButton = document.querySelector('.toggle-preset-messages');
const presetMessages = document.querySelectorAll('.preset-messages');

togglePresetButton.addEventListener('click', () => {
    presetMessages.forEach(container => {
        container.classList.toggle('show');
    });
});