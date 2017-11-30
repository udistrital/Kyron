package main

import (
	"fmt"
	"net/http"
  "net/url"
  "io/ioutil"
)

func main() {
	resp, err := http.PostForm("http://10.20.0.127/kyron/index.php?pagina=estadoDeCuentaCondor&bloqueNombre=estadoDeCuentaCondor&bloqueGrupo=reportes&procesarAjax=true&action=query&format=jwt", url.Values{"usuario": {"usuarioToken_CONSULTE_CON_EL_ADMINISTRADOR_KYRON"}, "clave": {"CONSULTE_SU_CLAVE_JWT_AL_ADMINISTRADOR_DE_KYRON"}})
	if err != nil {
		// handle error
	}
	defer resp.Body.Close()
	body, err := ioutil.ReadAll(resp.Body)
  fmt.Println(string(body[:]))

  token := string(body[:])

  docente := "79708124"
  resp, err = http.Get("http://10.20.0.127/kyron/index.php?data=" + token + "&docente=" + docente)
  if err != nil {
		// handle error
	}
	defer resp.Body.Close()
	body, err = ioutil.ReadAll(resp.Body)
  fmt.Println(string(body[:]))
}
