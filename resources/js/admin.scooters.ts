import axios from 'axios';
import IScooter from './interfaces/scooter';
import searchField from './searchField';
import selectedRows from './selectedRows';

const checkAll = (checked: boolean) => {
    const inputs = document.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    inputs.forEach((element) => {
        element.checked = checked;
    });
}

const getDetails = async (scooters: (string | null)[]) => {
    try {
        const res = await axios.post(`/admin/scooters/details`, {scooters});
        if (res.status === 200) {
            return res.data.data as IScooter[];
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return null;
    }
}

(async () => {
    const searchInput = document.getElementById("searchField") as HTMLInputElement | null;
    const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;

    const detailsBody = document.getElementById('modal-details-body') as HTMLElement | null;
    const detailsBodyTemplate = document.getElementById('modal-details-body-template') as HTMLTemplateElement | null;

    const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement | null;

    if (!detailsBody || !detailsBodyTemplate) {
        console.error("Could not find modal-details-body or modal-details-body-template");
        return;
    }

    if (!searchInput || !viewDetailsBtn) {
        console.error("Could not find search input");
        return;
    }

    if (!checkboxAll) {
        console.error("Could not find checkbox-all");
        return;
    }

    checkboxAll.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all clicked');
        checkAll(checkboxAll.checked);
    });

    viewDetailsBtn.addEventListener('click', async function (e: MouseEvent) {
        detailsBody.innerHTML = "";
        console.log('viewDetailsBtn clicked');
        const _scooters = selectedRows("[scooterid]").map((element) => element.getAttribute("scooterid"));
        if (_scooters.length === 0) {
            return;
        }

        const scooters = await getDetails(_scooters);
        if (!scooters) {
            console.error("Could not get details");
            return;
        }
        console.log(scooters);

        let n = 0;
        for (const scooter of scooters) {
            n++;

            const clone = document.importNode(detailsBodyTemplate.content, true);
            const fields = clone.querySelectorAll("h2");
            fields[0].textContent += `${scooter.id}`;
            fields[1].textContent += scooter.status;
            fields[2].textContent += scooter.model;
            fields[3].textContent += `${new Date(scooter.created_at)}` ?? 'N/A';
            fields[4].textContent += `${new Date(scooter.updated_at)}` ?? 'N/A';
            fields[5].textContent += `${scooter.longitude}`;
            fields[6].textContent += `${scooter.latitude}`;
            fields[7].textContent += scooter.used_by ?? 'N/A';

            detailsBody.appendChild(clone);
            if (n != scooters.length) {
                detailsBody.appendChild(document.createElement("hr"));
            }
        }
    });

    searchInput.addEventListener('keyup', (e) => {
        searchField(e, 5, '[scooteridParent]');
    });
})();
